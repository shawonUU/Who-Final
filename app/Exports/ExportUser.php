<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ExportUser implements FromCollection,WithHeadings
{

    protected $request;

    public function __construct( $request ) {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // dd($this->request);
        // $req = json_decode( $this->request, true );
        $req = $this->request;
        $type = $req['type'] ?? '';
        $div = $req['division_id'] ?? '';

        $query        = User::orderBy('id','desc');
        if($type == 'Completed'){
            $query->where('last_login_at','<',Carbon::now()->subDays(90)); //It should be Updated later
        }
        else if($type == 'Active'){
            $query->whereBetween('last_login_at',[Carbon::now()->subDays(30),Carbon::now()]);
        }
        else if($type == 'Hybernates'){
            $query->whereBetween('last_login_at',[Carbon::now()->subDays(30),Carbon::now()->subDays(90)]);
        }
        else if($type == 'Inactive'){
            $query->where('last_login_at','<',Carbon::now()->subDays(90));
        }

        //Filtering
        if( $div && $div!=null || $div!=''){
            $query->where('division',$div);
        }
        $data = $query->get();
        $arrOfData = [];

        foreach ( $data as $key => $item ) {
            $arr = [
                'SL'                        => $key+1 ?? null,
                'Full Name'                 => $item->name ?? null,
                'Phone'                     => $item->phone ?? null,
                'Date of Registration'      => $item->created_at ?? null,
                'Last Active Date'          => $item->last_login_at ?? null,
                'Gaps(Days)'                => Carbon::parse($item->last_login_at)->diffInDays(Carbon::now())
            ];

            array_push( $arrOfData, $arr );
        }
        return collect( $arrOfData );
    }

    public function headings(): array
    {
        return [
                'SL',
                'Full Name',
                'User Name',
                'Date of Registration',
                'Last Active Date',
                'Gaps(Days)',
        ];
    }
}

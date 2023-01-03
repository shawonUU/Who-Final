<div class="table-responsive">
    <table class="table table-striped" id="centerTypes-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Title</th>
                {{-- <th>Description</th> --}}
                <th>Status</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($course_faqs as $key => $course_faq)
            <tr>
                <td>{{ (((request('page') ?: 1)-1)*10)+$key+1 }}</td>
                <td>{{ $course_faq->course_faq_title }}</td>
                {{-- <td>{!! $course_faq->course_faq_description !!}</td> --}}
                <td>{!! $course_faq->status_buttons() !!}</td>
                <td class="index-action-td-width">
                    {!! Form::open(['route' => ['admin.course_faq.destroy', $course_faq->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <button type="button" class="btn btn-info btn-sm ml-1" data-toggle="modal" data-target="#courseFAQEditModal{{$course_faq->id}}">
                            <i class="fa fa-solid fa-pen" title="Edit"></i>
                        </button>
                        {!! Form::button('<i class="fa fa-solid fa-trash" title="Trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
            @include('admin.course_faq.elements.edit_modal')
        @endforeach
        </tbody>
    </table>
</div>

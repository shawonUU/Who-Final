class Filter {


    getDistricts(division_id,filter_postfix='') {
        console.log(division_id);
        $('.districtFilter'+filter_postfix).html('');
        $.ajax({
            url: base_url+"/get-districts/"+division_id,
            type: 'get',
            success: function (res) {
                console.log('res');
                $('.districtFilter'+filter_postfix).html('<option value="" >--Select One--</option>');
                $.each(res, function (key, value) {
                    $('.districtFilter'+filter_postfix).append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
                // $('.upazilaFilter').html('<option value="">Select upazila</option>');
            }
        });
    }
    getUpazilas(district_id,filter_postfix='') {
        $('.upazilaFilter'+filter_postfix).html('');
        $.ajax({
            url: base_url+"/get-upazila/"+district_id,
            type: 'get',
            success: function (res) {
                console.log(res);
                $('.upazilaFilter'+filter_postfix).html('<option value="">--Select One--</option>');
                $.each(res, function (key, value) {
                    $('.upazilaFilter'+filter_postfix).append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
                // $('.unionFilter').html('<option value="" disabled>Select union</option>');
            }
        });
    }
    getUnions(upazila_id,filter_postfix=''){
        $('.unionFilter'+filter_postfix).html('');
        $.ajax({
            url: base_url+"/get-union/"+upazila_id,
            type: 'get',
            success: function (res) {
                $('.unionFilter'+filter_postfix).html('<option value="">--Select One--</option>');
                $.each(res, function (key, value) {
                    $('.unionFilter'+filter_postfix).append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });
            }
        });
    }

    getStaffDesignationType(designation_id,filter_postfix='') {
        $('.staffDesignationTypeFilter'+filter_postfix).html('');
        $.ajax({
            url: base_url+"/get-staffDesignationType/"+designation_id,
            type: 'get',
            success: function (res) {

                $('.staffDesignationTypeFilter'+filter_postfix).html('<option value="">Select Any</option>');
                $.each(res, function (key, value) {
                    $('.staffDesignationTypeFilter'+filter_postfix).append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });

            }
        });
    }
}

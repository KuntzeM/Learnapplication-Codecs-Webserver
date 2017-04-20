/**
 * Created by mathias on 13.11.16.
 */

function checkMediaServerStatus(element) {

    $.ajax({
        url: '/admin/log/status',
        cache: false,
        type: 'GET',
        dataType: "json",
        error: function(data){
            $('#server_status').removeClass('label-success');
            $('#server_status').addClass('label-danger');
            $('#coding_status').removeClass('label-success');
            $('#coding_status').removeClass('label-default');
            $('#coding_status').addClass('label-danger');
        },
        success: function(data){

            if (data.success) {
                $('#server_status').removeClass('label-danger');
                $('#server_status').addClass('label-success');
            }

            if (data.isTranscoding) {
                $('#coding_status').removeClass('label-default');
                $('#coding_status').addClass('label-success');
            } else {
                $('#coding_status').removeClass('label-success');
                $('#coding_status').addClass('label-default');
            }
        },
        timeout: 2000 // sets timeout to 1 second
    });

    $.ajax({
        type: 'GET',
        url: '/ajax/get_file_size'
    });
}

function getTranscodingProcesses(token) {
    $.ajax({
        type: 'GET',
        data: {
            '_token': token,
        },
        url: 'admin/jobs/get',
        dataType: 'json',
        error: function (data) {
            /* var code = '<div class="ajax_alert alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> ' +
                '<strong>Error!</strong> cannot reach the media server</div> ';
             $('.alert_box').append(code);*/
        },
        success: function (data) {

            if (data.success) {
                $('.job').addClass('remove');
                $.each(data.jobs, function (index, value) {
                    if ($('#job_' + value.output.replace('.', '_')).length < 1) {
                        $('<tr class="job" id="job_' + value.output.replace('.', '_') + '">' +
                            '<td>' + value.name + '</td>' +
                            '<td>' + value.media_type + '</td>' +
                            '<td>' + value.codec + '</td>' +
                            '<td>' + value.bitrate + '</td>' +
                            '<td class="process">' +
                            '<div class="progress">' +
                            '<div class="progress-bar" role="progressbar" aria-valuenow="' + value.progress + '"  aria-valuemin="0" aria-valuemax="100" style="width: ' + value.progress + '%;">' + value.progress + '</div>' +
                            '</div>' +
                            '</td>' +
                            '</tr>').appendTo($('.table tbody'));
                    }
                    $('#job_' + value.output.replace('.', '_') + ' .progress-bar').text(parseInt(value.progress) + '%');
                    $('#job_' + value.output.replace('.', '_') + ' .progress-bar').attr('aria-valuenow', parseInt(value.progress));
                    $('#job_' + value.output.replace('.', '_') + ' .progress-bar').css('width', parseInt(value.progress) + '%');
                    $('#job_' + value.output.replace('.', '_')).removeClass('remove');
                });
                $('.job.remove .progress-bar').text('100%');
                $('.job.remove .progress-bar').attr('aria-valuenow', 100);
                $('.job.remove .progress-bar').css('width', 100 + '%');
                $('.job.remove').fadeOut();
            }
        }
    });
}

FooTable.MyFiltering = FooTable.Filtering.extend({ // inherit the base class
    construct: function (instance) {
        this._super(instance);
        this.statuses = ['info', 'warn', 'error']; // the options available in the dropdown
        this.def = 'alle Level'; // the default/unselected value for the dropdown (this would clear the filter when selected)
        this.$status = null; // a placeholder for our jQuery wrapper around the dropdown
    },
    $create: function () {
        this._super(); // call the base $create method, this populates the $form property
        var self = this, // hold a reference to my self for use later
            // create the bootstrap form group and append it to the form
            $form_grp = $('<div/>', {'class': 'form-group'})
                .append($('<label/>', {'class': 'sr-only', text: 'Status'}))
                .prependTo(self.$form);

        // create the select element with the default value and append it to the form group
        self.$status = $('<select/>', {'class': 'form-control'})
            .on('change', {self: self}, self._onStatusDropdownChanged)
            .append($('<option/>', {text: self.def}))
            .appendTo($form_grp);

        // add each of the statuses to the dropdown element
        $.each(self.statuses, function (i, status) {
            self.$status.append($('<option/>').text(status));
        });
    },
    _onStatusDropdownChanged: function (e) {
        var self = e.data.self, // get the MyFiltering object
            selected = $(this).val(); // get the current dropdown value
        if (selected !== self.def) { // if it's not the default value add a new filter
            self.addFilter('level', selected, ['level']);
        } else { // otherwise remove the filter
            self.removeFilter('level');
        }
        // initiate the actual filter operation
        self.filter();
    },
    draw: function () {
        this._super(); // call the base draw method, this will handle the default search input
        var status = this.find('level'); // find the status filter
        if (status instanceof FooTable.Filter) { // if it exists update the dropdown to reflect the value
            this.$status.val(status.query.val());
        } else { // otherwise update the dropdown to the default value
            this.$status.val(this.def);
        }
    }
});

function reloadLogTable(ft) {

    $.ajax({
        type: 'GET',
        url: '/admin/log/reload',
        dataType: 'json',
        success: function (data) {
            $('#log').rows.load(data);
        }
    });
}
<link rel="stylesheet" href="{{ url('admin-lib-bundle-css') }}">
<script src="{{ url('admin-lib-bundle-js') }}"></script>

<script>
    $.ajaxSetup({
        beforeSend: function(xhr, settings) {
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        }
    });

    jQuery('.input-datepicker').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    // progress baz
    $(document).ajaxStart(function() {
        Pace.restart();
    });

    const HelperService = {
        base_url: "{{ url('') }}",
        redirect: function(url) {
            window.location.href = this.base_url + url;
        },
        datepicker: function(selector) {
            jQuery(selector).datepicker({
                autoclose: true,
                todayHighlight: true
            });
        },
        showNotification: function(type, msg) {
            if (type == 'success') {
                toastr.success(msg);
            }

            if (type == 'error') {
                toastr.error(msg);
            }
        },
        loadingStart: function() {
            $('#main-wrapper-content').waitMe({
                effect: 'facebook',
            })
        },
        loadingStop: function() {
            $('#main-wrapper-content').waitMe("hide")
        },
        detectmob: function() {
            var check = false;
            (function(a) {
                if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i
                    .test(a) ||
                    /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i
                    .test(a.substr(0, 4))) check = true;
            })(navigator.userAgent || navigator.vendor || window.opera);
            return check;
        },
        autocomplete: function(selector, config) {
            $(selector)
                .autocomplete({
                    minLength: 0,
                    source: config.sources,
                    focus: function(event, ui) {
                        config.onFocus($(this), event, ui)
                        return false;
                    },
                    select: function(event, ui) {
                        config.onSelect($(this), event, ui)
                        return false;
                    }
                })

            $(selector).each(function() {
                $(this).data('ui-autocomplete')._renderItem = function(ul, item) {
                    return $("<li>")
                        .append(config.template(item))
                        .appendTo(ul);
                };
            });
        },
        thousandsSeparators: function(x = null) {
            return x == null ? 0 : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        setFormData: function($form, data) {
            $.each(data, function(key, value) {
                let $input = $form.find('[name="' + key + '"]');

                $input.val(data[key]);

                if ($input.is("select")) {
                    $input.val(data[key]).change();
                }
                if ($input.is(":checkbox")) {
                    $input.prop('checked', true);
                }
            });

            return this;
        },
        showLoadingUntilAllAjaxComplete: function() {
            HelperService.loadingStart();
            $(document).ajaxComplete(function(event, xhr, settings) {
                HelperService.loadingStop();
            });
        },
        isFunction: function(functionToCheck) {
            return functionToCheck && {}.toString.call(functionToCheck) === '[object Function]';
        },
        alert: function(type, msg) {
            if (type == 'success') {
                Swal.fire(
                    msg,
                    'Success',
                    'success'
                )
            }

            if (type == 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: msg,
                })
            }

        },
        confirm: function(callbackAction) {
            Swal.fire({
                title: 'Do you want to save the changes?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    callbackAction(result);
                }
            })
        }
    }

    class FormService {
        _form_data = '';
        _is_upload_form = '';
        _form_data_upload = null;
        _input_array_field = [];
        _input_upload_field = [];

        constructor(jqueryFormSelector) {
            this._form = jqueryFormSelector;
        }

        withArrayField(field = []) {
            this._input_array_field = field;
            return this;
        }

        withUploadField(field = []) {
            this._is_upload_form = true;
            this._input_upload_field = field;
            return this;
        }

        setFormData(data) {
            var $form = this._form;
            this._form_data = data;
            $.each(this._form.serializeArray(), function(i, field) {
                let $input = $form.find('[name="' + field.name + '"]')
                $input.val(data[field.name]);

                if ($input.is("select")) {
                    $input.val(data[field.name]).change();
                }
                if ($input.is(":checkbox")) {
                    $input.prop('checked', true);
                }
            });

            return this;
        }

        getFormData() {
            var data = {};
            var $form = this._form;
            var field_name_array;
            var formService = this;

            $.each($form.serializeArray(), function(i, field) {
                // if (_.includes(field.name, '[]') !== true) {
                //     data[field.name] = field.value;
                // } else {
                //     field_name = field.name.replace('[]', '');
                //     data[field_name] = $('[name="' + field.name + '"]').map(function () {
                //         return $(this).val()
                //     }).get();
                // }

                data[field.name] = field.value;
            });

            if (formService._input_array_field.length > 0) {
                $.each(formService._input_array_field, function(key, val) {
                    field_name_array = val;
                    if ($form.find('[name="' + field_name_array + '"]').is(':checkbox')) {
                        data[field_name_array] = $form.find('[name="' + field_name_array + '"]:checked').map(function() {
                            return $(this).val()
                        }).get();
                    } else {
                        data[field_name_array] = $form.find('[name="' + field_name_array + '"]').map(function() {
                            return $(this).val()
                        }).get();
                    }

                })
            }

            if (this._is_upload_form) {
                var form_data = new FormData();
                _.each(data, function(val, key) {
                    form_data.append(key, val);
                })
                _.each(this._input_upload_field, function(val) {
                    var $upload = $form.find('[name="' + val + '"]').prop('files');
                    if ($upload.length) {
                        form_data.append(val, $upload[0]);
                    }
                })
                this._form_data_upload = form_data;
            }
            this._form_data = data;

            return data;
        }

        emptyFormData() {
            var data = {};
            var $form = this._form;

            $.each($form.serializeArray(), function(i, field) {
                $('[name="' + field.name + '"]').val('');
                data[field.name] = '';
            });

            // remove validation msg
            $form.find('.invalid-feedback').text('');
            $form.find('.form-control').removeClass('is-invalid');

            this._form_data = data;

            return this;
        }

        validationResponseAjax(data) {
            var $form = this._form;
            $form.find('.invalid-feedback').text('');
            $form.find('.form-control').removeClass('is-invalid');
            $.each(data, function(field, pesan) {
                $form.find('[name="' + field + '"]').addClass('is-invalid');
                $form.find('[name="' + field + '"]').after('<div class="invalid-feedback">' + pesan + '</small>');
            })
        }

        typeahead(config) {

            var api_url = HelperService.base_url + config.url;
            var sources = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: api_url,
                remote: {
                    url: `${api_url}?search=%QUERY%`,
                    wildcard: '%QUERY'
                }
            });

            return $(config.selector).typeahead(null, {
                name: 'typeahead-' + Date.now(),
                display: config.display,
                highlight: true,
                source: sources
            })
        }

        onSubmit(callback) {
            var formInstance = this;

            formInstance._form.on('submit', function(e) {
                var form_data = formInstance.getFormData();
                var form_data_upload = formInstance._form_data_upload;
                callback(form_data, form_data_upload);
                e.preventDefault();
            })
        }
    }

    class HttpService {
        formService = null;
        bootrapTable = null;
        bootrapModal = null;
        method_type = '';
        data_param = null;

        constructor(config = null) {
            if (config != null) {
                if (config.formService) {
                    this.useForm(config.formService)
                }

                if (config.bootrapTable) {
                    this.useTable(config.bootrapTable)
                }

                if (config.bootrapModal) {
                    this.useModal(config.bootrapModal)
                }
            }
        }

        useForm(formService) {
            this.formService = formService;
            return this;
        }

        useTable(bootrapTable) {
            this.bootrapTable = bootrapTable;
            return this;
        }

        useModal(bootrapModal) {
            this.bootrapModal = bootrapModal;
            return this;
        }

        httpEvent(eventName, callback) {
            if (eventName === 'onStart') {
                return callback;
            }
        }

        // event
        onStart() {
            HelperService.loadingStart();
        }

        onSuccess(resp) {
            HelperService.loadingStop();

            if (resp.success) {
                HelperService.showNotification('success', resp.message);
            } else {
                HelperService.showNotification('error', 'terjadi kesalahan');
            }

            if (this.formService != null) {
                this.formService.emptyFormData();
            }

            if (this.bootrapTable != null) {
                if (HelperService.isFunction(this.bootrapTable)) {
                    this.bootrapTable(resp);
                } else {
                    switch (this.method_type) {
                        case 'POST':
                            if (this.data_param.id != '') {
                                // this.bootrapTable.bootstrapTable('updateByUniqueId', {
                                //     id: resp.data.id,
                                //     row: resp.data
                                // });
                            } else {
                                // this.bootrapTable.bootstrapTable('append', resp.data);
                            }
                            this.bootrapTable.bootstrapTable('refresh');
                            break;
                        case 'PUT':
                            // this.bootrapTable.bootstrapTable('updateByUniqueId', {
                            //     id: resp.data.id,
                            //     row: resp.data
                            // });
                            this.bootrapTable.bootstrapTable('refresh');
                            break;
                        case 'DELETE':
                            if (this.data_param == null) {
                                this.bootrapTable.bootstrapTable('refresh');
                            } else {
                                this.bootrapTable.bootstrapTable('removeByUniqueId', this.data_param.id)
                            }
                            break;
                        default:
                            this.bootrapTable.bootstrapTable('refresh');
                    }
                }
            }

            if (this.bootrapModal != null) {
                this.bootrapModal.modal('hide');
            }
        }

        onError(request, status, error) {
            console.log('request', request)
            console.log('status', status)
            console.log('error', error)
            if (request.responseJSON) {
                HelperService.showNotification('error', request.responseJSON.message);
                if (request.status == 422) {
                    var errorValidation = request.responseJSON.data;
                    if (this.formService != null) {
                        this.formService.validationResponseAjax(errorValidation);
                    }
                }
            } else {
                HelperService.showNotification('error', error);
            }
            HelperService.loadingStop();
        }

        core(type, url, data) {
            this.method_type = type;
            this.data_param = data;

            var httpInstance = this;
            // Creating a promise
            return new Promise(function(resolve, reject) {

                httpInstance.onStart();

                var is_upload = false;
                if (httpInstance.formService != null) {
                    if (httpInstance.formService._is_upload_form) {
                        is_upload = true;
                    }
                }

                $.ajax({
                    type: type,
                    url: HelperService.base_url + url,
                    data: data,
                    contentType: is_upload ? false : 'application/x-www-form-urlencoded; charset=UTF-8',
                    processData: is_upload ? false : true,
                    success: function(resp) {
                        httpInstance.onSuccess(resp);
                        resolve(resp);
                    },
                    error: function(request, status, error) {
                        httpInstance.onError(request, status, error);
                        reject(request, status, error);
                    }
                });
            });
        }

        ajax(type, url, data) {
            // Creating a promise
            return new Promise(function(resolve, reject) {
                $.ajax({
                    type: type,
                    url: HelperService.base_url + url,
                    data: data,
                    success: function(resp) {
                        resolve(resp);
                    },
                    error: function(request, status, error) {
                        reject(request, status, error);
                    }
                });
            });
        }

        get(url, data) {
            return this.core('GET', url, data);
        }

        post(url, data) {
            return this.core('POST', url, data);
        }

        put(url, data) {
            return this.core('PUT', url, data);
        }

        delete(url, data) {
            return this.core('DELETE', url, data);
        }
    }

    // bootstrapTable extend config
    $.extend($.fn.bootstrapTable.defaults, {
        uniqueId: 'id',
        showColumns: true,
        search: true,
        showRefresh: true,
        showFooter: false,
        cardView: HelperService.detectmob(),
        pagination: true,
        height: 600,
        pageSize: 10,
        sortName: 'id',
        sortOrder: 'desc',
        sidePagination: 'server',
        pageList: [10, 20, 50, 100],
        classes: 'table table-hover table-no-bordered',
        responseHandler: function(res) {
            return res.data;
        },
    })

    // event onload error ajax bootrap-table
    $('table').on('load-error.bs.table', function(el, status, request) {
        console.group();
        console.log('event onload error ajax bootrap-table');
        console.log('status', status);
        console.log('request', request);
        console.group();

        if (status != 0) {
            HelperService.showNotification('error', request.responseJSON.message)
        }
    });
</script>
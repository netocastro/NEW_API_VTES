$(document).ready(function () {
      $('#form-register').on('submit', function(e){
            e.preventDefault();
            _this = $(this);

            $.ajax({    
                  url:  _this.attr('action'),
                  type:  _this.attr('method'),
                  dataType:  _this.attr('data-type'),
                  data:  _this.serialize(),
                  beforeSend: function() {
                        _this.find('.load').removeClass('d-none').addClass('d-flex');                 
                  },
                  success: (data) =>{
                        console.log(data);
                        validateFields(data, $(this));
                  },
                  error: (error) =>{
                        console.log(error.responseText);
                  }
            }).always( function() {
                  _this.find('.load').removeClass('d-flex').addClass('d-none');
            });
      });
});
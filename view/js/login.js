$(document).ready(function() {

      $('#form-login').on('submit', function(e){
            e.preventDefault();
            _this = $(this);
            $.ajax({
                  url: $(this).attr('action'),
                  type: $(this).attr('method'),
                  dataType: $(this).attr('data-type'),
                  data: $(this).serialize(),
                  beforeSend: function() {
                        _this.find('.load').removeClass('d-none').addClass('d-flex');
                  },
                  success: (data) =>{
                        if(data.success){
                              window.location.href = userPanel;
                              console.log(userPanel);
                              return;
                        }
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
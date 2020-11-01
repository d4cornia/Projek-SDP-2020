@extends('mandor.navbar')

@section('content')
<h1>Request Dana</h1>
<div class="option" style="margin-left:78%">
    <a class="btn btn-primary"  href="/mandor/lihatRequestDana" style="width:250px"><font size="3">Lihat Request Dana</font></a>
</div>
<h1>Anda Telah Melakukan Request!</h1>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
</script>

@endsection

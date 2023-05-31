<!-- jQuery CDN Library -->
<script src="/js/bootstrap/jquery-3.6.0.min.js"></script>
<!-- BOOTSTRAP LIBRARY -->
<link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<script src="/js/bootstrap/bootstrap.bundle.min.js"></script>
<!-- DATATABLE LIBRARY -->
<link rel="stylesheet" href="/css/bootstrap/datatables.min.css">
<script src="/js/bootstrap/datatables.min.js"></script>
<!-- CUSTOM CSS -->
<link rel="stylesheet" href="/css/style_department.css">

<!--EXPORT-->
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>



<form class="needs-validation" novalidate>
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="validationCustom01">First name</label>
            <input type="text" class="form-control" id="validationCustom01" placeholder="First name" required>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationCustom02">Last name</label>
            <input type="text" class="form-control" id="validationCustom02" placeholder="Last name"  required>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationCustomUsername">Username</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                </div>
                <input type="text" class="form-control" id="validationCustomUsername" placeholder="Username" aria-describedby="inputGroupPrepend" required>
                <div class="invalid-feedback">
                    Please choose a username.
                </div>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="validationCustom03">City</label>
            <input type="text" class="form-control" id="validationCustom03" placeholder="City" required>
            <div class="invalid-feedback">
                Please provide a valid city.
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <label for="validationCustom04">State</label>
            <input type="text" class="form-control" id="validationCustom04" placeholder="State" required>
            <div class="invalid-feedback">
                Please provide a valid state.
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <label for="validationCustom05">Zip</label>
            <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" required>
            <div class="invalid-feedback">
                Please provide a valid zip.
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
            <label class="form-check-label" for="invalidCheck">
                Agree to terms and conditions
            </label>
            <div class="invalid-feedback">
                You must agree before submitting.
            </div>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Submit form</button>
</form>

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
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Decrypt JOSS</title>
    <link rel="shortcut icon" href="{{ asset('JOOS-TRANS1.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
</head>
<body>
{{-- NAV BAR --}}
    <nav class="navbar bg-primary" style="justify-content:flex-start;">
        <div class="container-fluid">
            <a class="navbar-brand" >
                <img src="{{ asset('JOOS-TRANS1.png') }}" alt="Logo" width="115" height="70" class="d-inline-block align-text-top">
            </a>
            <h5 style="margin-right: 10px; color:azure">JOSS Decrypt</h5>
        </div>
    </nav>
{{-- NAVBAR END --}}
<div class="main-container">
    <section class=" space--sm" >
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-12">
                        <div class="boxed boxed--border"  style="background-color: #A10000">
                            <form id="generate_form" method="POST" action="/home/hashing">
                                @csrf
                                <h2 class="pt-5 text-center text-white">JOSS Hash Generator</h2>
                                <div class="container-fluid">
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="plain_text" class="h5 mb-2 text-white">Plain Text Input</label>
                                            <input type="text" id="plain_text" name="plain_text" class="mb-2 form-control form-control-lg" placeholder="String" @if(isset($password))value="{{ $password }}"@endif autofocus required />
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-2">
                                            <label for="cost_factor" class="h5 mb-2 text-white">Cost Factor</label>
                                            <div class="input-select">
                                                <select id="cost_factor" name="cost_factor" class="form-select form-select-lg">
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12" selected>12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <a href="https://security.stackexchange.com/a/17238" target="_blank" rel="noopener noreferrer" title="How to Choose the Right Cost for Bcrypt" class="learn-more-lnk text-white" style="font-size:11px">How to Choose the Right Cost Factor »</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <input type="submit" class="mb-2 ms-3  btn btn-primary btn-md btn-block" style="width: 100%" value="GENERATE HASH">
                                        </div>
                                        <div class="col-sm-4">
                                            <a href="/home" type="button" class="ms-4 btn btn-outline-light " style="width: 80%">RESET FORM</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <hr>
                                            <div class="row">
                                                <div class="col-12 mb-5">
                                                    <p class="h5 mb-2 text-white">Output</p>
                                                    @if(isset($hashedPassword))
                                                    <div class="form-control alert alert-success mt-3" role="alert">
                                                        <input type="text" id="hashed_password" name="hashed_password" value="{{ $hashedPassword }}" hidden>
                                                        {{ $hashedPassword }}
                                                    </div>
                                                    <button type="button" class="btn btn-md btn-primary copy-button" onclick="copyData()"><i class="fas fa-copy"></i> Copy To Verify Hash</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between" id="bcrypt-hash-validator-verifier">
                    <div class="col-12">
                        <div class="boxed boxed--border pt-5" style="background-color:  #A10000; height:30em">
                            <h2 class="text-center text-white">JOSS Hash Verifier</h2>

                            <form id="verifier_form" method="POST" action="/home/verify">
                                @csrf
                                <div class="container-fluid">
                                    <div class="row mb-5">
                                        <div class="col">
                                            <label for="verify_hash" class="text-white h5 mb-2">Hash</label>
                                            <input type="text" id="verify_hash" name="verify_hash" class="form-control form-control-lg" placeholder="Hash To Check" @if(isset($verify_hash))value="{{ $verify_hash }}"@endif autofocus required />
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col">
                                            <label for="verify_plain_text" class="text-white h5 mb-2">Plain Text</label>
                                            <input type="text" id="verify_plain_text" name="verify_plain_text" class="form-control form-control-lg" placeholder="String To Check Against" @if(isset($verify_plain_text))value="{{ $verify_plain_text }}"@endif required /> 
                                        </div>
                                    </div>
                                    @if(isset($verification))
                                        <div class="modal fade" id="verificationModal" tabindex="-1" aria-labelledby="verificationModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="verificationModalLabel">Verification Result</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if($verification === 'valid')
                                                            <div class="alert alert-success" role="alert">
                                                                Match !!!
                                                            </div>
                                                        @else
                                                            <div class="alert alert-danger" role="alert">
                                                                Not a match !!!!!!!
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <input type="submit" class="mb-2 ms-3  btn btn-primary btn-md" style="width: 100%" value="VERIFY HASH">
                                        </div>
                                        <div class="col-sm-4">
                                            <a href="/home" type="button" class="ms-4 btn btn-outline-light" style="width: 80%">RESET FORM</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
<footer class="pt-4 bg-primary">
    <div class="container">
        <div class="row">
            <div class="col text-center" style="color: white">
                <h6>© Copyright Team JOOS 2023</h6>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script>
    function copyData() {
        var plaintText = document.getElementById("plain_text").value;
        var hashedPassword = document.getElementById("hashed_password").value;

        document.getElementById("verify_plain_text").value = plaintText;
        document.getElementById("verify_hash").value = hashedPassword;
    }
</script>
<script>
    window.addEventListener('DOMContentLoaded', function () {
        var verificationModal = new bootstrap.Modal(document.getElementById('verificationModal'));
        verificationModal.show();
    });
</script>
</html>
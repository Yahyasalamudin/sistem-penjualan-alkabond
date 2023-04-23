@extends('layouts.app')

@section('content')
<div class="row py-4">
    <div class="col">
          <h1 class="h3 mb-3 text-gray-800"> Detail Pesanan</h1>
          <hr>

      </div>
</div>
    <div class="row">
      <div class="col-md-8 col-auto">
        <form action="" method="post" id="registration">
          <nav>
            <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
              <a class="nav-link active" id="step1-tab" data-bs-toggle="tab" href="#step1">Detail Pesanan</a>
              <a class="nav-link" id="step2-tab" data-bs-toggle="tab" href="#step2">Pembayaran</a>
              <a class="nav-link" id="step3-tab" data-bs-toggle="tab" href="#step3">Return Pesanan</a>
            </div>
          </nav>
          <div class="tab-content py-4">
            <div class="tab-pane fade show active" id="step1">
              <h4>Personal data</h4>
              <div class="mb-3">
                <label for="field1">Required text field 1</label>
                <input type="text" name="field1" class="form-control" id="field1" required>
              </div>
              <div class="mb-3">
                <label for="field2">Required email field 2</label>
                <input type="email" name="field2" class="form-control" id="field2" required>
              </div>
              <div class="mb-3">
                <label for="field3">Optional field</label>
                <input type="text" name="field3" class="form-control" id="field3">
              </div>
            </div>
            <div class="tab-pane fade" id="step2">
              <h4>Contact information</h4>
              <div class="mb-3">
                <label for="field4">Required field 1</label>
                <input type="text" name="field4" class="form-control" id="field4" required>
              </div>
              <div class="mb-3">
                <label for="field5">Optional field</label>
                <input type="text" name="field5" class="form-control" id="field5">
              </div>
              <div class="mb-3">
                <label for="textarea1">Required field 2</label>
                <textarea name="textarea1" rows="5" class="form-control" id="textarea1" required></textarea>
              </div>
            </div>
            <div class="tab-pane fade" id="step3">
              <h4>Review your information</h4>
              <div class="mb-3">
                <label for="first_name">Required field 1</label>
                <input type="text" class="form-control-plaintext" value="Lorem ipsum dolor sit amet">
              </div>
              <div class="mb-3">
                <label for="first_name">Optional field</label>
                <input type="text" class="form-control-plaintext" value="Lorem ipsum dolor sit amet">
              </div>
              <div class="mb-3">
                <label for="first_name">Required field 2</label>
                <input type="text" class="form-control-plaintext" value="Lorem ipsum dolor sit amet">
              </div>
            </div>
          </div>
          {{-- <div class="row justify-content-between">
            <div class="col-auto"><button type="button" class="btn btn-secondary" data-enchanter="previous">Previous</button></div>
            <div class="col-auto">
              <button type="button" class="btn btn-primary" data-enchanter="next">Next</button>
              <button type="submit" class="btn btn-primary" data-enchanter="finish">Finish</button>
            </div>
          </div> --}}
        </form>
      </div>
    </div>


  @endsection


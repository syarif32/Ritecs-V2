@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Edit Awarding</h2>
      <p class="text-muted">Form untuk memperbarui data awarding</p>

      <div class="row">
        <div class="col-md-8">

          <div class="card shadow mb-4">
            <div class="card-body position-relative">
              
              <form action="{{ route('admin.awardings.update', $award->awarding_id) }}" 
                  method="POST" enctype="multipart/form-data" 
                  class="needs-validation" novalidate>
                  @csrf
                  @method('PUT')

                  <div class="form-row">
                      <!-- Cover -->
                      <div class="form-group col-md-12">
                          <label for="coverImage" class="font-weight-bold">Awarding Cover</label>
                          <div class="upload-box" id="uploadBox">
                              <input type="file" id="coverImage" name="coverImage" accept="image/*" hidden>
                              <img id="previewImage" 
                                  src="{{ $award->cover_path ? asset($award->cover_path) : asset('assets/published/awards/award_default.png') }}" 
                                  alt="Preview" style="max-width: 150px;">
                          </div>
                      </div>

                      <!-- Title -->
                      <div class="form-group col-12 col-xl-6">
                          <label for="title">Title</label>
                          <input type="text" id="title" name="title" 
                                value="{{ $award->title }}" class="form-control" required>
                      </div>

                      <!-- Penulis -->
                      <div class="form-group col-12 col-xl-6">
                          <label for="penulis">Penulis</label>
                          <input type="text" id="penulis" name="penulis" 
                                value="{{ $award->penulis }}" class="form-control">
                      </div>

                      <!-- Abstract -->
                      <div class="form-group col-12">
                          <label for="abstract">Abstract</label>
                          <textarea id="abstract" name="abstract" 
                                    class="form-control" rows="4">{{ $award->abstract }}</textarea>
                      </div>

                      <!-- Volume -->
                      <div class="form-group col-12 col-xl-6">
                          <label for="volume_no">Volume No</label>
                          <input type="text" id="volume_no" name="volume_no" 
                                value="{{ $award->volume_no }}" class="form-control">
                      </div>

                      <!-- Jenis Jurnal -->
                      <div class="form-group col-12 col-xl-6">
                          <label for="jenis_jurnal">Jenis Jurnal</label>
                          <input type="text" id="jenis_jurnal" name="jenis_jurnal" 
                                value="{{ $award->jenis_jurnal }}" class="form-control">
                      </div>

                      <!-- URL Path -->
                      <div class="form-group col-12 col-xl-6">
                          <label for="url_path">Url Path</label>
                          <input type="text" id="url_path" name="url_path" 
                                value="{{ $award->url_path }}" class="form-control">
                      </div>

                      <!-- Keywords -->
                      <div class="col-12 col-xl-6 position-relative">
                          <div class="form-group w-100 position-relative">
                              <label for="multi-select2">Keyword</label>
                              <select class="form-control select2-multi" 
                                      name="keywords[]" id="multi-select2" multiple>
                                  @foreach($allKeywords as $keyword)
                                      <option value="{{ $keyword->keyword_id }}" 
                                          {{ in_array($keyword->keyword_id, $award->keywords->pluck('keyword_id')->toArray()) ? 'selected' : '' }}>
                                          {{ $keyword->name }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                      </div>

                      <!-- Buttons -->
                      <div class="col-12 d-flex justify-content-start mt-3">
                          <button type="submit" class="btn btn-primary mr-2">Save Changes</button>
                          <a href="{{ route('admin.awardings.index') }}" class="btn btn-secondary">Cancel</a>
                      </div>
                  </div>
              </form>

              
            </div>
          </div>

        </div>
      </div> 

    </div>
  </div>
</div> <!-- .container-fluid -->
@endsection

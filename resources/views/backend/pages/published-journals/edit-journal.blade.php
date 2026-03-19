@extends('backend.layouts.main')

@section('content')

        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <h2 class="page-title">Form advanced elements</h2>
              <p class="text-muted">Demo for form control styles, layout options, and custom components for creating a wide variety of forms.</p>

              <div class="row">
                <div class="col-md-8">

                  <div class="card shadow mb-4">
                    <div class="card-body position-relative">
                      
                      <form action="{{ route('admin.update-journals', $journal->journal_id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                      @csrf

                          <div class="form-row">
                            <!-- Cover -->
                            <div class="form-group col-md-12">
                                <label for="coverImage" class="font-weight-bold">Journal Cover</label>
                                <div class="upload-box" id="uploadBox">
                                    <input type="file" id="coverImage" name="coverImage" accept="image/*" hidden>
                                    <img id="previewImage" 
                                        src="{{ $journal->cover_path ? asset($journal->cover_path) : asset('assets/published/journals/journal_default.png') }}" 
                                        alt="Preview" style="max-width: 150px;">
                                </div>
                            </div>

                            <!-- Title -->
                            <div class="form-group col-12 col-xl-6">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" value="{{ $journal->title }}" class="form-control">
                            </div>

                            <!-- URL Path -->
                            <div class="form-group col-12 col-xl-6">
                                <label for="url_path">Url Path</label>
                                <input type="text" id="url_path" name="url_path" value="{{ $journal->url_path }}" class="form-control">
                            </div>

                            <!-- Keywords -->
                            <div class="col-12 position-relative">
                                <div class="form-group w-100 position-relative">
                                    <label for="multi-select2">Category</label>
                                    <select class="form-control select2-multi" name="keywords[]" id="multi-select2" multiple>
                                        @foreach($allKeywords as $keyword)
                                          <option value="{{ $keyword->keyword_id }}" 
                                              {{ in_array($keyword->keyword_id, $journal->keywords->pluck('keyword_id')->toArray()) ? 'selected' : '' }}>
                                              {{ $keyword->name }}
                                          </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="col-12 d-flex justify-content-start mt-3">
                                <button type="submit" class="btn btn-primary mr-2">Save Changes</button>
                                <a href="{{ route('admin.published-journals') }}" class="btn btn-secondary">Cancel</a>
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

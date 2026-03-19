

@extends('backend.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <h2 class="page-title">Membership Card Settings</h2>
      <p class="card-text">Customize membership card design and text positioning</p>

      <div class="row">
        <div class="col-md-7">
          <div class="card shadow mb-4">
            <div class="card-body">
              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                  {{ session('success') }}
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
              @endif

              <form action="{{ route('admin.membership-card-settings.update') }}" method="POST" enctype="multipart/form-data" id="cardSettingsForm">
                @csrf
                @method('PUT')

                <!-- Upload Images -->
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label class="font-weight-bold">Front Card Design (PNG/JPG)</label>
                    <div class="upload-box" onclick="document.getElementById('front_image').click()">
                      <input type="file" id="front_image" name="front_image" accept="image/*" hidden onchange="previewFront(this)">
                      <img id="preview_front" 
                        src="{{ $settings->front_image_path ? asset($settings->front_image_path) : asset('assets/img/placeholder-card.png') }}"
                        alt="Front Card" style="max-width: 100%; max-height: 200px;">
                    </div>
                    <small class="text-muted">Recommended: 856 x 540 px (KTP size)</small>
                  </div>

                  <div class="form-group col-md-6">
                    <label class="font-weight-bold">Back Card Design (PNG/JPG)</label>
                    <div class="upload-box" onclick="document.getElementById('back_image').click()">
                      <input type="file" id="back_image" name="back_image" accept="image/*" hidden onchange="previewBack(this)">
                      <img id="preview_back" 
                        src="{{ $settings->back_image_path ? asset($settings->back_image_path) : asset('assets/img/placeholder-card.png') }}"
                        alt="Back Card" style="max-width: 100%; max-height: 200px;">
                    </div>
                    <small class="text-muted">Recommended: 856 x 540 px</small>
                  </div>
                </div>
                
                <hr class="mt-4">

                <!-- Font Management -->
                <h5 class="mb-3">Font Settings</h5>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">Select Font</label>
                      <select name="font_file" id="font_select" class="form-control preview-trigger">
                        <option value="">-- Use Default System Font --</option>
                        @foreach($fonts as $font)
                          <option value="{{ $font['filename'] }}" 
                            {{ (isset($settings->font_file) && $settings->font_file == $font['filename']) ? 'selected' : '' }}>
                            {{ $font['name'] }} ({{ $font['size'] }} KB)
                          </option>
                        @endforeach
                      </select>
                      <small class="text-muted">Choose custom font for membership card text</small>
                    </div>
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">Upload New Font</label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="font_upload" accept=".ttf,.otf">
                        <label class="custom-file-label" for="font_upload">Choose font file...</label>
                      </div>
                      <small class="text-muted">Supported: TTF, OTF (max 5MB)</small>
                    </div>
                  </div>
                </div>
                
                <!-- Font List -->
                @if(count($fonts) > 0)
                <div class="table-responsive mt-3 rounded">
                  <table class="table table-sm table-bordered">
                    <thead class="thead-light">
                      <tr>
                        <th>Font Name</th>
                        <th>File Size</th>
                        <th width="100">Action</th>
                      </tr>
                    </thead>
                    <tbody id="font_list">
                      @foreach($fonts as $font)
                      <tr data-filename="{{ $font['filename'] }}">
                        <td>{{ $font['name'] }}</td>
                        <td>{{ $font['size'] }} KB</td>
                        <td>
                          <button type="button" class="btn btn-sm btn-danger delete-font" data-filename="{{ $font['filename'] }}">
                            <i class="fe fe-trash"></i>
                          </button>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                @else
                <div class="alert alert-info">
                  No custom fonts uploaded yet. Upload a font file to get started!
                </div>
                @endif

                <hr class="my-4">

                <!-- Name Position & Style -->
                <h5 class="mb-3">Member Name Settings</h5>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label>Position X</label>
                    <input type="number" name="name_x" class="form-control preview-trigger" value="{{ $settings->name_position['x'] }}" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Position Y</label>
                    <input type="number" name="name_y" class="form-control preview-trigger" value="{{ $settings->name_position['y'] }}" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Font Size</label>
                    <input type="number" name="name_font_size" class="form-control preview-trigger" value="{{ $settings->name_position['font_size'] }}" min="12" max="100" required>
                    <small class="text-muted">Recommended: 36-60</small>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Color</label>
                    <input type="color" name="name_color" class="form-control preview-trigger" value="{{ $settings->name_position['color'] }}" required>
                  </div>
                </div>

                <!-- Member Number Position & Style -->
                <h5 class="mb-3">Member Number Settings</h5>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label>Position X</label>
                    <input type="number" name="member_number_x" class="form-control preview-trigger" value="{{ $settings->member_number_position['x'] }}" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Position Y</label>
                    <input type="number" name="member_number_y" class="form-control preview-trigger" value="{{ $settings->member_number_position['y'] }}" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Font Size</label>
                    <input type="number" name="member_number_font_size" class="form-control preview-trigger" value="{{ $settings->member_number_position['font_size'] }}" min="12" max="100" required>
                    <small class="text-muted">Recommended: 20-36</small>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Color</label>
                    <input type="color" name="member_number_color" class="form-control preview-trigger" value="{{ $settings->member_number_position['color'] }}" required>
                  </div>
                </div>

                <!-- Expired Date Position & Style -->
                <h5 class="mb-3">Expiry Date Settings</h5>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label>Position X</label>
                    <input type="number" name="expired_x" class="form-control preview-trigger" value="{{ $settings->expired_date_position['x'] }}" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Position Y</label>
                    <input type="number" name="expired_y" class="form-control preview-trigger" value="{{ $settings->expired_date_position['y'] }}" required>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Font Size</label>
                    <input type="number" name="expired_font_size" class="form-control preview-trigger" value="{{ $settings->expired_date_position['font_size'] }}" min="12" max="100" required>
                    <small class="text-muted">Recommended: 14-24</small>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Color</label>
                    <input type="color" name="expired_color" class="form-control preview-trigger" value="{{ $settings->expired_date_position['color'] }}" required>
                  </div>
                </div>

                <div class="mt-4">
                  <button type="submit" class="btn btn-primary">Save Settings</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Live Preview -->
        <div class="col-md-5">
          <div class="card shadow sticky-top" style="top: 20px;">
            <div class="card-header">
              <h5 class="mb-0">Live Preview</h5>
            </div>
            <div class="card-body text-center">
              <img id="live_preview" src="{{ asset($settings->front_image_path ?? 'assets/img/placeholder-card.png') }}" 
                   alt="Preview" class="img-fluid border-none" style="max-width: 100%;">
              <div class="mt-3">
                <small class="text-muted">Preview will update as you change settings</small>
              </div>
            </div>
            <div class="card-footer">
              <button type="button" class="btn btn-primary" onclick="generatePreview()">Refresh Preview</button>
            </div> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    <script>
    function previewFront(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('preview_front').src = e.target.result;
          setTimeout(() => generatePreview(), 500);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    
    function previewBack(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('preview_back').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    
    // Auto-generate preview when settings change
    document.querySelectorAll('.preview-trigger').forEach(input => {
      input.addEventListener('input', function() {
        clearTimeout(window.previewTimeout);
        window.previewTimeout = setTimeout(() => generatePreview(), 500);
      });
    });
    
    function generatePreview() {
      console.log('🔄 Generating preview...');
      
      const url = "{{ route('admin.membership-card-preview') }}";
      console.log('📍 Preview URL:', url);
      
      const formData = new FormData(document.getElementById('cardSettingsForm'));
      
      // ✅ PENTING: Hapus _method agar tidak bentrok dengan POST
      formData.delete('_method');
      
      // Log form data untuk debugging
      console.log('📦 Form data:');
      for (let [key, value] of formData.entries()) {
        if (key !== 'front_image' && key !== 'back_image') {
          console.log('  ' + key + ': ' + value);
        }
      }
      
      // Get CSRF token dengan fallback
      let csrfToken;
      const metaTag = document.querySelector('meta[name="csrf-token"]');
      if (metaTag) {
        csrfToken = metaTag.content;
      } else {
        const tokenInput = document.querySelector('input[name="_token"]');
        if (tokenInput) {
          csrfToken = tokenInput.value;
        }
      }
      
      if (!csrfToken) {
        console.error('❌ CSRF token not found!');
        return;
      }
      
      console.log('🔑 CSRF Token: Found');
      
      fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => {
        console.log('📡 Response status:', response.status, response.statusText);
        
        if (!response.ok) {
          return response.text().then(text => {
            console.error('❌ Server response:', text.substring(0, 500));
            throw new Error('Server error: ' + response.status);
          });
        }
        return response.json();
      })
      .then(data => {
        console.log('✅ Preview data received');
        if (data.image) {
          document.getElementById('live_preview').src = data.image;
          console.log('✅ Preview image updated successfully');
        } else if (data.error) {
          console.error('❌ Preview error from server:', data.error);
        } else {
          console.error('❌ Unexpected response format');
        }
      })
      .catch(error => {
        console.error('❌ Fetch error:', error.message);
      });
    }
    
    // Initial preview
    document.addEventListener('DOMContentLoaded', function() {
      console.log('🚀 Page loaded, generating initial preview...');
      setTimeout(() => generatePreview(), 1000);
    });
    
    
    
    // Font upload handler
    document.getElementById('font_upload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        // Validasi client-side
        const validExtensions = ['ttf', 'otf'];
        const fileExtension = file.name.split('.').pop().toLowerCase();
        
        if (!validExtensions.includes(fileExtension)) {
            alert('❌ File harus berformat TTF atau OTF');
            e.target.value = '';
            document.querySelector('.custom-file-label').textContent = 'Choose font file...';
            return;
        }
        
        if (file.size > 5 * 1024 * 1024) { // 5MB
            alert('❌ Ukuran file maksimal 5MB');
            e.target.value = '';
            document.querySelector('.custom-file-label').textContent = 'Choose font file...';
            return;
        }
        
        // Get CSRF token
        let csrfToken;
        const metaTag = document.querySelector('meta[name="csrf-token"]');
        if (metaTag) {
            csrfToken = metaTag.content;
        } else {
            const tokenInput = document.querySelector('input[name="_token"]');
            if (tokenInput) {
                csrfToken = tokenInput.value;
            }
        }
        
        if (!csrfToken) {
            alert('❌ CSRF token tidak ditemukan');
            return;
        }
        
        // Create FormData dan tambahkan file + token
        const formData = new FormData();
        formData.append('font_file', file);
        formData.append('_token', csrfToken); // ⭐ INI PENTING - token di body juga
        
        console.log('📤 Uploading font:', file.name);
        console.log('📦 File size:', (file.size / 1024).toFixed(2), 'KB');
        console.log('🔑 CSRF Token:', csrfToken.substring(0, 10) + '...');
        
        // Tampilkan loading indicator
        const uploadBtn = document.querySelector('.custom-file-label');
        const originalText = uploadBtn.textContent;
        uploadBtn.textContent = '⏳ Uploading... Please wait';
        
        fetch("{{ route('admin.membership-card-fonts.upload') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken, // Header juga tetap dikirim
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('📡 Response status:', response.status, response.statusText);
            
            // Coba parse response untuk mendapatkan error detail
            return response.json().then(data => {
                if (!response.ok) {
                    console.error('❌ Server error response:', data);
                    throw new Error(data.message || `Upload failed with status: ${response.status}`);
                }
                return data;
            });
        })
        .then(data => {
            console.log('✅ Upload response:', data);
            
            if (data.success) {
                alert('✅ ' + data.message);
                // Reload halaman untuk refresh daftar font
                setTimeout(() => location.reload(), 500);
            } else {
                alert('❌ ' + (data.message || 'Upload failed'));
                uploadBtn.textContent = originalText;
            }
        })
        .catch(error => {
            console.error('❌ Upload error:', error);
            alert('❌ Failed to upload font: ' + error.message);
            uploadBtn.textContent = originalText;
        })
        .finally(() => {
            // Reset input
            e.target.value = '';
        });
    });
    
    // Font delete handler
    document.querySelectorAll('.delete-font').forEach(btn => {
      btn.addEventListener('click', function() {
        const filename = this.getAttribute('data-filename');
        
        if (!confirm(`Delete font "${filename}"?`)) return;
        
        const formData = new FormData();
        formData.append('filename', filename);
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        
        fetch("{{ route('admin.membership-card-fonts.delete') }}", {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('✅ ' + data.message);
            // Remove row dari tabel
            document.querySelector(`tr[data-filename="${filename}"]`).remove();
            // Remove dari dropdown
            document.querySelector(`option[value="${filename}"]`)?.remove();
          } else {
            alert('❌ ' + data.message);
          }
        })
        .catch(error => {
          console.error('Delete error:', error);
          alert('Failed to delete font');
        });
      });
    });
    
    // Update label saat pilih file
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
      const fileName = e.target.files[0]?.name || 'Choose font file...';
      document.querySelector('.custom-file-label').textContent = fileName;
    });
    
    // Trigger preview saat ganti font
    document.getElementById('font_select').addEventListener('change', function() {
      generatePreview();
    });
    </script>
@endsection
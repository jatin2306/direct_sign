<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin Panel') | DirectDeal</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />  
  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed:300,500,600,700%7CRoboto:300,400,500,700">

  <!-- Global CSS -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/font-awesome/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/flaticon/flaticon.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <!-- Page Specific CSS -->
  @stack('styles')

  <style>
    body {
      font-family: 'Barlow Semi Condensed', sans-serif;
      background-color: #f4f6f9;
    }

    .sidebar {
      width: 240px;
      background-color: #343a40;
    }

    .main-wrapper {
      margin-left: 240px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    @media (max-width: 768px) {
      .sidebar {
        position: relative;
        width: 100%;
      }
      .main-wrapper {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  @include('admin.layouts.sidebar')

  <!-- Main Content -->
  <div class="main-wrapper">
    <!-- Header -->
    @include('admin.layouts.header')

    <!-- Content -->
    <main class="flex-grow-1 p-4">
      @yield('content')
    </main>

    <!-- Optional Footer (if needed) -->
    {{-- <footer class="text-center py-3 small text-muted">© {{ date('Y') }} DirectDeal Admin Panel</footer> --}}
  </div>

  <!-- Global JS -->
  <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
  


  <script>
    document.querySelectorAll('.delete-image-btn').forEach(button => {
        button.addEventListener('click', function () {
            const imageId = this.dataset.id;
            const confirmed = confirm("Are you sure you want to delete this image?");
            if (!confirmed) return;

            const form = document.getElementById('deleteImageForm');
            form.action = `/admin/properties/images/${imageId}`;
            form.submit();
        });
    });
</script>


<script>
    const imageUpload = document.getElementById('imageUpload');
    const imagePreview = document.getElementById('imagePreview');
    let selectedFiles = [];

    imageUpload.addEventListener('change', function (event) {
        selectedFiles = Array.from(event.target.files);
        updatePreview();
    });

    function updatePreview() {
        imagePreview.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const wrapper = document.createElement('div');
                wrapper.classList.add('preview-wrapper');

                const img = document.createElement('img');
                img.src = e.target.result;

                const fileName = document.createElement('div');
                fileName.classList.add('file-name');
                fileName.textContent = file.name;

                const removeBtn = document.createElement('button');
                removeBtn.textContent = '×';
                removeBtn.classList.add('remove-preview');
                removeBtn.onclick = function () {
                    selectedFiles.splice(index, 1);
                    updatePreview();
                };

                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                wrapper.appendChild(fileName);
                imagePreview.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });

        updateInputFiles();
    }

    function updateInputFiles() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        imageUpload.files = dataTransfer.files;
    }
</script>
  <!-- Page Specific JS -->
  @stack('scripts')
</body>
</html>

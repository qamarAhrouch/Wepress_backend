<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legal Announcements</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        .announcement-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .announcement-card img {
            width: 120px;
            height: 120px;
            object-fit: cover;
        }

        .announcement-content {
            padding: 15px;
            flex: 1;
        }

        .announcement-content h5 {
            margin: 0 0 10px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .announcement-content p {
            margin: 0 0 5px;
            color: #666;
            font-size: 14px;
        }

        .announcement-content .location {
            color: #007bff;
            font-size: 14px;
        }

        .view-button {
            margin: 0 15px;
        }

        .view-button a {
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            text-align: center;
            display: inline-block;
        }

        .view-button a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
     <!-- Dashboard Button -->
     <button>
        <a href="{{ route('admin') }}" style="color: white; text-decoration: none;">Dashboard</a>
    </button> 
    <br> <br>
    <div class="container py-5">
        <h1 class="text-center mb-4">Legal Announcements</h1>

        @foreach ($annoncess as $annonce)
        <div class="announcement-card">
            <!-- Image Placeholder -->
            <img src="{{ asset('public.images.wepress.jpg') }}" alt="Announcement Image">

            <!-- Content -->
            <div class="announcement-content">
                <h5>{{ strtoupper($annonce->title) }}</h5>
                <p>{{ Str::limit($annonce->content, 150, '...') }}</p>
                
                <p>
                    <i class="fas fa-calendar-alt"></i> {{ $annonce->date_parution ?? 'N/A' }}
                </p>
            </div>

            <!-- View Button -->
            <div class="view-button">
                <a href="{{ route('annonces.show', $annonce->id) }}">
                    <i class="fas fa-eye"></i> Voir
                </a>
            </div>
        </div>
        @endforeach

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $annoncess->links() }}
        </div>
    </div>
</body>
</html>

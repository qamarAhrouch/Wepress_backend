<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }

        .container {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
        }

        .header {
            font-size: 1.5em;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .field {
            margin-bottom: 15px;
        }

        .field-label {
            font-weight: bold;
        }

        .field-value {
            margin-left: 10px;
            color: #333;
        }

        .back-button {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .back-button a {
            text-decoration: none;
            color: white;
            background: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
        }

        .back-button a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            {{ strtoupper($annonce->type) }}: {{ $annonce->title }}
        </div>

        <!-- Announcement Details -->
        <div class="field">
            <span class="field-label">Title:</span>
            <span class="field-value">{{ $annonce->title ?? 'No title provided' }}</span>
        </div>

        <div class="field">
            <span class="field-label">Type:</span>
            <span class="field-value">{{ $annonce->type ?? 'No type provided' }}</span>
        </div>

        <div class="field">
            <span class="field-label">ICE:</span>
            <span class="field-value">{{ $annonce->ice ?? 'No ICE provided' }}</span>
        </div>

        <div class="field">
            <span class="field-label">Publication Canale:</span>
            <span class="field-value">{{ $annonce->canal_de_publication ?? 'No publication channel provided' }}</span>
        </div>

        <div class="field">
            <span class="field-label">Ville:</span>
            <span class="field-value">{{ $annonce->ville ?? 'No city provided' }}</span>
        </div>

        <div class="field">
            <span class="field-label">Publication Web:</span>
            <span class="field-value">
                @if ($annonce->publication_web == 1)
                    Yes
                @elseif ($annonce->publication_web === 0)
                    No
                @else
                    Not specified
                @endif
            </span>
        </div>

        <div class="field">
            <span class="field-label">File Attachment:</span>
            <span class="field-value">{{ $annonce->file_attachment ?? 'No file attached' }}</span>
        </div>

        <div class="field">
            <span class="field-label">Ref Web:</span>
            <span class="field-value">{{ $annonce->ref_web ?? 'No reference provided' }}</span>
        </div>

        <div class="field">
            <span class="field-label">Date Created:</span>
            <span class="field-value">{{ $annonce->created_at->format('Y-m-d H:i:s') ?? 'No creation date provided' }}</span>
        </div>

        <div class="field">
            <span class="field-label">Date Parution:</span>
            <span class="field-value">
                @if ($annonce->date_parution)
                    {{ \Carbon\Carbon::parse($annonce->date_parution)->format('Y-m-d') }}
                @else
                    No parution date provided
                @endif
            </span>
        </div>

        <div class="field">
            <span class="field-label">User:</span>
            <span class="field-value">{{ $annonce->user->name ?? 'No user provided' }}</span>
        </div>
        <div class="field">
            <span class="field-label">Status:</span>
            <span class="field-value">{{ $annonce->status?? 'no status found!!' }}</span>
        </div>


        <div class="field">
            <span class="field-label">Description:</span>
            <span class="field-value">{{ $annonce->content ?? 'No description provided' }}</span>
        </div>

        <div class="back-button">
            <a href="{{ url()->previous() }}">Back</a>
        </div>
    </div>
</body>
</html>

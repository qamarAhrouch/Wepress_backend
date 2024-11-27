@extends('layouts.app')

@section('content')
<h1 style="text-align: center; margin-bottom: 20px;">Create Annonce</h1>

<div style="display: flex; justify-content: center; gap: 20px;">
    <!-- Form Section -->
    <div style="width: 40%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9;">
        <form action="{{ route('annonces.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 10px;">
                <label for="canal_de_publication" style="display: block; font-weight: bold; margin-bottom: 5px;">Canal de Publication:</label>
                <select name="canal_de_publication" id="canal_de_publication" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="Papier + Digital">Papier + Digital</option>
                    <option value="Digital uniquement">Digital uniquement</option>
                </select>
            </div>

            <div style="margin-bottom: 10px;">
                <label for="title" style="display: block; font-weight: bold; margin-bottom: 5px;">Title:</label>
                <input type="text" name="title" id="title" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;" oninput="updatePreview()">
            </div>

            <div style="margin-bottom: 10px;">
                <label for="type" style="display: block; font-weight: bold; margin-bottom: 5px;">Type:</label>
                <select name="type" id="type" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="" disabled selected>Select Type</option> 
                    <option value="constitution">Constitution</option>
                    <option value="cessation">Cessation</option>
                    <option value="modification">Modification</option>
                </select>
            </div>

            <div style="margin-bottom: 10px;">
                <label for="content" style="display: block; font-weight: bold; margin-bottom: 5px;">Content:</label>
                <textarea name="content" id="content" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; height: 80px;" oninput="updatePreview()"></textarea>
            </div>

            <div style="margin-bottom: 10px;">
                <label for="file_attachment" style="display: block; font-weight: bold; margin-bottom: 5px;">Joindre Fichiers (Optional):</label>
                <input type="file" name="file_attachment" id="file_attachment" accept=".pdf,.jpeg,.png,.docx,.doc" style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 10px;">
                <label for="date_parution" style="display: block; font-weight: bold; margin-bottom: 5px;">Date Parution:</label>
                <input type="date" name="date_parution" id="date_parution" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 10px;">
                <label for="ice" style="display: block; font-weight: bold; margin-bottom: 5px;">ICE:</label>
                <input type="text" name="ice" id="ice" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 10px;">
                <label for="ville" style="display: block; font-weight: bold; margin-bottom: 5px;">Ville:</label>
                <select name="ville" id="ville" required style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="" disabled selected>Choose a city</option>
                    <option value="Casablanca">Casablanca</option>
                    <option value="Rabat">Rabat</option>
                    <option value="Marrakech">Marrakech</option>
                    <option value="Fes">Fes</option>
                    <option value="Tangier">Tangier</option>
                    <option value="Agadir">Agadir</option>
                    <option value="Oujda">Oujda</option>
                    <option value="Kenitra">Kenitra</option>
                    <option value="Tetouan">Tetouan</option>
                    <option value="Safi">Safi</option>
                    <option value="Mohammedia">Mohammedia</option>
                    <option value="Laayoune">Laayoune</option>
                    <option value="Beni Mellal">Beni Mellal</option>
                    <option value="Nador">Nador</option>
                    <option value="Settat">Settat</option>
                    <option value="El Jadida">El Jadida</option>
                    <option value="Taza">Taza</option>
                    <option value="Khemisset">Khemisset</option>
                    <option value="Khouribga">Khouribga</option>
                    <option value="Berkane">Berkane</option>
                    <option value="Dakhla">Dakhla</option>
                    <option value="Ifrane">Ifrane</option>
                </select>
            </div>

            <div style="margin-bottom: 10px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Publier votre annonce sur le web?</label>
                <label><input type="radio" name="publication_web" value="1" required> Oui</label>
                <label><input type="radio" name="publication_web" value="0"> Non</label>
            </div>

            <div style="text-align: center;">
                <button type="submit" style="padding: 8px 16px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Create Annonce</button>
            </div>
        </form>
    </div>

    <!-- Preview and Total Section -->
    <div style="width: 35%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background-color: #f5f5f5;">
        <h2>Aperçu de l'annonce</h2>
        <div id="previewContent" style="border: 1px solid #000; padding: 8px; text-align: center; overflow-wrap: break-word; word-wrap: break-word; white-space: normal; max-width: 100%; height: auto;">
            <p id="previewTitle" style="font-weight: bold; word-break: break-word;"></p>
            <p id="previewBody" style="word-break: break-word; white-space: pre-line;"></p>
        </div>
    </div>
</div>

<!-- JavaScript for Live Preview and Date Picker -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputDate = document.getElementById('date_parution');
        const today = new Date();
        const weekendDays = [0, 6]; // Sunday = 0, Saturday = 6
        const publicHolidays = [
            "01-01", // New Year's Day
            "05-01", // Labour Day
            "07-30", // Throne Day
            "08-20", // Revolution of the King and the People
            "08-21", // Youth Day
            "11-06", // Green March
            "11-18"  // Independence Day
        ];

        let minDate = new Date(today);
        minDate.setDate(minDate.getDate() + 2); // Add 2 days for processing

        // Check if a date is non-working (weekend or holiday)
        const isNonWorkingDay = (date) => {
            const formattedDate = `${String(date.getMonth() + 1).padStart(2, "0")}-${String(date.getDate()).padStart(2, "0")}`;
            return weekendDays.includes(date.getDay()) || publicHolidays.includes(formattedDate);
        };

        // Get the next valid date that is not a weekend or holiday
        const getNextValidDate = (date) => {
            const newDate = new Date(date);
            while (isNonWorkingDay(newDate)) {
                newDate.setDate(newDate.getDate() + 1);
            }
            return newDate;
        };

        // Ensure the initial minimum date skips non-working days
        minDate = getNextValidDate(minDate);
        inputDate.min = minDate.toISOString().split('T')[0];

        // Disable weekends and holidays dynamically
        inputDate.addEventListener('input', function () {
            const selectedDate = new Date(this.value);

            // If the selected date is invalid, reset to the minimum date
            if (isNonWorkingDay(selectedDate)) {
                alert("La date sélectionnée tombe un week-end ou un jour férié. Veuillez choisir une autre date .");
                this.value = "";
            }
        });
    });
</script>

@endsection

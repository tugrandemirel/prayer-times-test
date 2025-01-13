<!DOCTYPE html>
<html>
<head>
    <title>Prayer Times</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Prayer Times</h1>
        
        <div class="card mb-4">
            <div class="card-header">
                <h3>Today's Prayer Times</h3>
            </div>
            <div class="card-body">
                @foreach($daily as $prayer => $time)
                    <div class="row mb-2">
                        <div class="col-4">{{ $prayer }}</div>
                        <div class="col-8">{{ $time }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3>Monthly Calendar</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <!-- Monthly calendar data -->
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h3>Other Information</h3>
            </div>
            <div class="card-body">
                <p>Qibla Direction: {{ $qibla }}°</p>
                <p>Is Special Day: {{ $isSpecialDay ? 'Yes' : 'No' }}</p>
            </div>
        </div>
    </div>
</body>
</html> 
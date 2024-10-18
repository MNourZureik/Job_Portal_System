<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Job Opportunity</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .job-details {
            border: 1px solid #ddd;
            padding: 20px;
            margin: 20px 0;
        }
        .job-details h2 {
            color: #333;
        }
        .job-details p {
            margin: 5px 0;
        }
        .job-details .label {
            font-weight: bold;
        }
    </style>
</head>
<body>
<h1>Hello, {{ $jobSeekerName }}!</h1>
<p>We have a new job opportunity that might interest you:</p>

<div class="job-details">
    <h2>{{ $jobTitle }}</h2>
    <p><span class="label">Company:</span> {{ $company }}</p>
    <p><span class="label">Location:</span> {{ $location }} ({{ $city }}, {{ $country }})</p>
    <p><span class="label">Job Type:</span> {{ $jobType }}</p>
    <p><span class="label">Salary:</span> {{ $salary }} {{ $currency }} ({{ $salaryType }})</p>
    <p><span class="label">Remote:</span> {{ $remotely }}</p>
    <p><span class="label">Start Date:</span> {{ $startDate }}</p>
    <p><span class="label">End Date:</span> {{ $endDate }}</p>
    <p><span class="label">Required Skills:</span> {{ $requiredSkills }}</p>

    <h3>Job Description:</h3>
    <p>{{ $description }}</p>
</div>

<p>If you are interested in this position, please apply as soon as possible.</p>
<p>Best regards,</p>
<p>The {{ config('app.name') }} Team</p>
</body>
</html>

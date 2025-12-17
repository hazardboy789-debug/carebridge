<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Prescription</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px double #4CAF50;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .clinic-name {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .clinic-info {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .title {
            text-align: center;
            font-size: 24px;
            color: #4CAF50;
            margin: 20px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .patient-info, .doctor-info {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #4CAF50;
        }
        
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #4CAF50;
        }
        
        .medication-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        
        .medication-table th {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            text-align: left;
        }
        
        .medication-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .medication-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .signature-section {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
        }
        
        .signature-box {
            float: right;
            text-align: center;
            width: 300px;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            margin: 40px auto 5px;
        }
        
        .footer {
            margin-top: 80px;
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .prescription-code {
            background-color: #f0f0f0;
            padding: 5px 10px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 14px;
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="clinic-name">HealthCare Clinic</div>
        <div class="clinic-info">
            123 Medical Street, Healthcare City<br>
            Phone: (123) 456-7890 | Email: info@healthcareclinic.com<br>
            License No: MED-2024-001
        </div>
    </div>
    
    <div class="title">Medical Prescription</div>
    
    <div class="prescription-code">Prescription ID: {{ $prescriptionCode }}</div>
    
    <div class="info-section">
        <div class="patient-info" style="width: 48%;">
            <div class="section-title">Patient Information</div>
            <p><strong>Name:</strong> {{ $patient->name }}</p>
            <p><strong>Date of Birth:</strong> {{ $patient->date_of_birth ?? 'N/A' }}</p>
            <p><strong>Patient ID:</strong> {{ $patient->id }}</p>
            <p><strong>Date:</strong> {{ $date }}</p>
        </div>
        
        <div class="doctor-info" style="width: 48%;">
            <div class="section-title">Prescribing Doctor</div>
            <p><strong>Name:</strong> Dr. {{ $doctor->name }}</p>
            <p><strong>License No:</strong> {{ $doctor->medical_license ?? 'MED-12345' }}</p>
            <p><strong>Specialty:</strong> {{ $doctor->specialty ?? 'General Medicine' }}</p>
        </div>
    </div>
    
    <div style="clear: both;"></div>
    
    <div class="diagnosis-section">
        <div class="section-title">Diagnosis</div>
        <p>{{ $prescription->diagnosis }}</p>
    </div>
    
    @if(!empty($labTests))
    <div class="lab-tests-section" style="margin-bottom: 25px;">
        <div class="section-title">Recommended Lab Tests</div>
        <ul>
            @foreach($labTests as $test)
                <li>{{ $test }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <div class="medications-section">
        <div class="section-title">Prescribed Medications</div>
        <table class="medication-table">
            <thead>
                <tr>
                    <th>Medication</th>
                    <th>Dosage</th>
                    <th>Frequency</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medications as $index => $medication)
                    @php
                        $parts = explode('|', $medication);
                        $name = $parts[0] ?? $medication;
                        $dosage = $parts[1] ?? 'As directed';
                        $frequency = $parts[2] ?? 'Daily';
                        $duration = $parts[3] ?? '7 days';
                    @endphp
                    <tr>
                        <td>{{ $name }}</td>
                        <td>{{ $dosage }}</td>
                        <td>{{ $frequency }}</td>
                        <td>{{ $duration }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="instructions-section">
        <div class="section-title">Instructions & Notes</div>
        <p>{{ $prescription->instructions }}</p>
        
        @if($prescription->notes)
        <div style="margin-top: 15px;">
            <strong>Additional Notes:</strong>
            <p>{{ $prescription->notes }}</p>
        </div>
        @endif
    </div>
    
    @if($prescription->follow_up_date)
    <div class="followup-section" style="margin-top: 25px;">
        <div class="section-title">Follow-up</div>
        <p><strong>Follow-up Date:</strong> {{ \Carbon\Carbon::parse($prescription->follow_up_date)->format('F d, Y') }}</p>
        <p><strong>Purpose:</strong> Review progress and adjust treatment if necessary</p>
    </div>
    @endif
    
    <div class="warning">
        <strong>⚠️ Important:</strong> This prescription is valid for 30 days from issue date. 
        Take medications as prescribed. Do not share medications with others. 
        Contact your doctor immediately if you experience any adverse reactions.
    </div>
    
    <div class="signature-section">
        <div class="signature-box">
            @if($prescription->signature_path)
                <img src="{{ storage_path('app/public/' . $prescription->signature_path) }}" 
                     alt="Doctor's Signature" 
                     style="max-width: 200px; max-height: 80px;">
            @else
                <div class="signature-line"></div>
            @endif
            <p><strong>Dr. {{ $doctor->name }}</strong></p>
            <p>Medical License: {{ $doctor->medical_license ?? 'MED-12345' }}</p>
            <p>Date: {{ $date }}</p>
        </div>
        <div style="clear: both;"></div>
    </div>
    
    <div class="footer">
        <p>This is an electronically generated prescription. No physical signature required.</p>
        <p>For verification: Scan QR code or visit our website with Prescription ID: {{ $prescriptionCode }}</p>
        <p>© {{ date('Y') }} HealthCare Clinic. All rights reserved.</p>
    </div>
</body>
</html>
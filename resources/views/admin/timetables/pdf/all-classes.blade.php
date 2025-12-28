<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Classes Timetables</title>
    <style>
        @page {
            margin: 15mm;
            size: A4;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 9px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 8px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #1e40af;
        }
        .header p {
            margin: 3px 0;
            font-size: 11px;
            color: #666;
        }
        .class-section {
            page-break-inside: avoid;
            margin-bottom: 25px;
        }
        .class-title {
            background-color: #2563eb;
            color: white;
            padding: 8px;
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th {
            background-color: #1e40af;
            color: white;
            padding: 5px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #1e3a8a;
            font-size: 8px;
        }
        td {
            padding: 4px;
            border: 1px solid #ddd;
            vertical-align: top;
            font-size: 8px;
        }
        .period-box {
            background-color: #dbeafe;
            border-left: 3px solid #2563eb;
            padding: 3px;
            margin: 1px 0;
            border-radius: 2px;
        }
        .period-subject {
            font-weight: bold;
            font-size: 8px;
            color: #1e40af;
        }
        .period-teacher {
            font-size: 7px;
            color: #666;
            margin-top: 1px;
        }
        .period-room {
            font-size: 7px;
            color: #999;
            margin-top: 1px;
        }
        .time-slot {
            font-weight: bold;
            background-color: #f3f4f6;
            width: 80px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sir Isaac Newton School</h1>
        <p><strong>All Classes Timetables</strong></p>
        <p>Academic Year: {{ $academicYear }}</p>
    </div>

    @foreach($classes as $class)
        @if(isset($allTimetables[$class->id]) && $allTimetables[$class->id]->isNotEmpty())
            <div class="class-section">
                <div class="class-title">
                    {{ $class->name }} ({{ $class->code }}) - {{ $class->level }}
                </div>

                @php
                    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
                    $classTimetables = $allTimetables[$class->id];
                    $timeSlots = [];
                    
                    foreach ($classTimetables as $dayTimetables) {
                        foreach ($dayTimetables as $timetable) {
                            $timeKey = $timetable->start_time->format('H:i') . '-' . $timetable->end_time->format('H:i');
                            if (!isset($timeSlots[$timeKey])) {
                                $timeSlots[$timeKey] = [
                                    'start' => $timetable->start_time->format('H:i'),
                                    'end' => $timetable->end_time->format('H:i'),
                                ];
                            }
                        }
                    }
                    ksort($timeSlots);
                    
                    $timetableByDay = [];
                    foreach ($days as $day) {
                        $timetableByDay[$day] = isset($classTimetables[$day]) ? $classTimetables[$day] : collect();
                    }
                @endphp

                <table>
                    <thead>
                        <tr>
                            <th class="time-slot">Time</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timeSlots as $timeSlot)
                            <tr>
                                <td class="time-slot">{{ $timeSlot['start'] }}<br>{{ $timeSlot['end'] }}</td>
                                @foreach($days as $day)
                                    <td>
                                        @php
                                            $period = $timetableByDay[$day]->first(function($t) use ($timeSlot) {
                                                return $t->start_time->format('H:i') === $timeSlot['start'] 
                                                    && $t->end_time->format('H:i') === $timeSlot['end'];
                                            });
                                        @endphp
                                        @if($period)
                                            <div class="period-box">
                                                <div class="period-subject">{{ $period->subject->name }}</div>
                                                @if($period->teacher)
                                                    <div class="period-teacher">{{ $period->teacher->first_name }} {{ $period->teacher->last_name }}</div>
                                                @endif
                                                @if($period->room)
                                                    <div class="period-room">{{ $period->room }}</div>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endforeach

    <div class="footer">
        <p>Generated on {{ now()->format('F d, Y \a\t H:i') }} | Sir Isaac Newton School Management System</p>
    </div>
</body>
</html>


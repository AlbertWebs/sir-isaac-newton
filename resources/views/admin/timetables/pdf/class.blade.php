<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable - {{ $class->name }}</title>
    <style>
        @page {
            margin: 20mm;
            size: A4 landscape;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #1e40af;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th {
            background-color: #2563eb;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #1e40af;
        }
        td {
            padding: 6px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .period-box {
            background-color: #dbeafe;
            border-left: 4px solid #2563eb;
            padding: 4px;
            margin: 2px 0;
            border-radius: 3px;
        }
        .period-subject {
            font-weight: bold;
            font-size: 9px;
            color: #1e40af;
        }
        .period-teacher {
            font-size: 8px;
            color: #666;
            margin-top: 2px;
        }
        .period-room {
            font-size: 8px;
            color: #999;
            margin-top: 1px;
        }
        .time-slot {
            font-weight: bold;
            background-color: #f3f4f6;
            width: 100px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sir Isaac Newton School</h1>
        <p><strong>{{ $class->name }} ({{ $class->code }})</strong> - {{ $class->level }}</p>
        <p>Academic Year: {{ $academicYear }}</p>
        <p>Timetable</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="time-slot">Time</th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
                <th>Saturday</th>
            </tr>
        </thead>
        <tbody>
            @php
                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
                $timeSlots = [];
                
                foreach ($timetables as $dayTimetables) {
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
                    $timetableByDay[$day] = isset($timetables[$day]) ? $timetables[$day] : collect();
                }
            @endphp

            @if(!empty($timeSlots))
                @foreach($timeSlots as $timeSlot)
                    <tr>
                        <td class="time-slot">{{ $timeSlot['start'] }} - {{ $timeSlot['end'] }}</td>
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
                                            <div class="period-room">Room: {{ $period->room }}</div>
                                        @endif
                                    </div>
                                @else
                                    <div style="color: #ccc; font-size: 8px;">-</div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #999;">
                        No timetable entries found for this class.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>Generated on {{ now()->format('F d, Y \a\t H:i') }} | Sir Isaac Newton School Management System</p>
    </div>
</body>
</html>


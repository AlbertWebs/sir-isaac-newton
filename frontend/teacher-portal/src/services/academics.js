import api from './api';

export const getClasses = async (academicYear, level) => {
  const params = new URLSearchParams();
  if (academicYear) params.append('academic_year', academicYear);
  if (level) params.append('level', level);
  
  const response = await api.get(`/academics/classes?${params}`);
  return response.data;
};

export const getTimetables = async (classId, academicYear) => {
  const params = new URLSearchParams();
  if (classId) params.append('class_id', classId);
  if (academicYear) params.append('academic_year', academicYear);
  
  const response = await api.get(`/academics/timetables?${params}`);
  return response.data;
};

export const getAttendance = async (studentId, dateFrom, dateTo) => {
  const params = new URLSearchParams();
  if (studentId) params.append('student_id', studentId);
  if (dateFrom) params.append('date_from', dateFrom);
  if (dateTo) params.append('date_to', dateTo);
  
  const response = await api.get(`/academics/attendance?${params}`);
  return response.data;
};

export const markAttendance = async (studentId, courseId, attendanceDate, status, notes) => {
  const response = await api.post('/academics/attendance/mark', {
    student_id: studentId,
    course_id: courseId,
    attendance_date: attendanceDate,
    status,
    notes,
  });
  return response.data;
};

export const getResults = async (studentId, academicYear) => {
  const params = new URLSearchParams();
  if (studentId) params.append('student_id', studentId);
  if (academicYear) params.append('academic_year', academicYear);
  
  const response = await api.get(`/academics/results?${params}`);
  return response.data;
};

export const storeResult = async (resultData) => {
  const response = await api.post('/academics/results', resultData);
  return response.data;
};


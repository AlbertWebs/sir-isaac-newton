import api from './api';

export const getMyChildren = async () => {
  // This would need a specific endpoint for parents to get their children
  // For now, we'll use the students endpoint with filtering
  const response = await api.get('/students');
  return response.data;
};

export const getStudentDetails = async (studentId) => {
  const response = await api.get(`/students/${studentId}`);
  return response.data;
};

export const getStudentAttendance = async (studentId, dateFrom, dateTo) => {
  const params = new URLSearchParams();
  if (dateFrom) params.append('date_from', dateFrom);
  if (dateTo) params.append('date_to', dateTo);
  
  const response = await api.get(`/students/${studentId}/attendance?${params}`);
  return response.data;
};

export const getStudentResults = async (studentId, academicYear) => {
  const params = new URLSearchParams();
  if (academicYear) params.append('academic_year', academicYear);
  
  const response = await api.get(`/students/${studentId}/results?${params}`);
  return response.data;
};

export const getStudentTransportStatus = async (studentId) => {
  const response = await api.get(`/transport/status/${studentId}`);
  return response.data;
};


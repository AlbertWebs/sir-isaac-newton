export const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api/v1';

export const getAuthToken = () => {
  return localStorage.getItem('teacher_token');
};

export const setAuthToken = (token) => {
  localStorage.setItem('teacher_token', token);
};

export const removeAuthToken = () => {
  localStorage.removeItem('teacher_token');
};


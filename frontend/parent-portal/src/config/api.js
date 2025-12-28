export const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api/v1';

export const getAuthToken = () => {
  return localStorage.getItem('parent_token');
};

export const setAuthToken = (token) => {
  localStorage.setItem('parent_token', token);
};

export const removeAuthToken = () => {
  localStorage.removeItem('parent_token');
};


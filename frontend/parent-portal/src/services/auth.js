import api from './api';
import { setAuthToken, removeAuthToken } from '../config/api';

export const login = async (email, password) => {
  const response = await api.post('/auth/login', {
    email,
    password,
    user_type: 'parent',
  });
  
  if (response.data.token) {
    setAuthToken(response.data.token);
    return response.data;
  }
  
  throw new Error('Login failed');
};

export const logout = async () => {
  try {
    await api.post('/auth/logout');
  } catch (error) {
    console.error('Logout error:', error);
  } finally {
    removeAuthToken();
  }
};

export const getCurrentUser = async () => {
  const response = await api.get('/auth/me');
  return response.data.user;
};


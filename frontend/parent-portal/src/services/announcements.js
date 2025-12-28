import api from './api';

export const getAnnouncements = async () => {
  const response = await api.get('/announcements');
  return response.data;
};

export const getAnnouncement = async (id) => {
  const response = await api.get(`/announcements/${id}`);
  return response.data;
};


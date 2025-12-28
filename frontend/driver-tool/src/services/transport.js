import api from './api';

export const getMyRoutes = async () => {
  const response = await api.get('/transport/driver/my-routes');
  return response.data;
};

export const getTripStudents = async (tripId) => {
  const response = await api.get(`/transport/driver/trip/${tripId}/students`);
  return response.data;
};

export const markPickup = async (logId, status, latitude, longitude, notes) => {
  const response = await api.post(`/transport/driver/pickup/${logId}`, {
    status,
    latitude,
    longitude,
    notes,
  });
  return response.data;
};


import { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { ArrowLeft, MapPin, Users, Clock, Calendar } from 'lucide-react';
import api from '../services/api';

export default function RouteDetail({ user }) {
  const { id } = useParams();
  const navigate = useNavigate();
  const [route, setRoute] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    loadRoute();
  }, [id]);

  const loadRoute = async () => {
    try {
      const response = await api.get(`/transport/routes/${id}`);
      setRoute(response.data);
    } catch (error) {
      console.error('Error loading route:', error);
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-lg">Loading route...</div>
      </div>
    );
  }

  if (!route) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-lg text-red-600">Route not found</div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <header className="bg-blue-600 text-white shadow-lg">
        <div className="max-w-7xl mx-auto px-4 py-4">
          <div className="flex items-center space-x-4">
            <button
              onClick={() => navigate('/')}
              className="p-2 hover:bg-blue-700 rounded-lg transition"
            >
              <ArrowLeft className="w-6 h-6" />
            </button>
            <div>
              <h1 className="text-xl font-bold">{route.name}</h1>
              <p className="text-sm text-blue-100">{route.code}</p>
            </div>
          </div>
        </div>
      </header>

      {/* Main Content */}
      <main className="max-w-7xl mx-auto px-4 py-6">
        {/* Route Info */}
        <div className="bg-white rounded-lg shadow-md p-6 mb-6">
          <h2 className="text-lg font-bold text-gray-800 mb-4">Route Information</h2>
          <div className="grid md:grid-cols-2 gap-4">
            <div>
              <p className="text-sm text-gray-600">Vehicle</p>
              <p className="font-medium">
                {route.vehicle?.registration_number || 'Not assigned'}
              </p>
            </div>
            <div>
              <p className="text-sm text-gray-600">Status</p>
              <span className={`px-2 py-1 text-xs rounded ${
                route.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'
              }`}>
                {route.status}
              </span>
            </div>
          </div>
        </div>

        {/* Stops */}
        {route.stops && route.stops.length > 0 && (
          <div className="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 className="text-lg font-bold text-gray-800 mb-4 flex items-center">
              <MapPin className="w-5 h-5 mr-2" />
              Route Stops ({route.stops.length})
            </h2>
            <div className="space-y-3">
              {route.stops
                .sort((a, b) => a.stop_order - b.stop_order)
                .map((stop, index) => (
                  <div key={stop.id} className="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div className="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">
                      {index + 1}
                    </div>
                    <div className="flex-1">
                      <p className="font-medium text-gray-800">{stop.name}</p>
                      {stop.address && (
                        <p className="text-sm text-gray-600">{stop.address}</p>
                      )}
                      {stop.estimated_arrival_time && (
                        <p className="text-sm text-gray-500 mt-1">
                          <Clock className="w-3 h-3 inline mr-1" />
                          {stop.estimated_arrival_time}
                        </p>
                      )}
                    </div>
                  </div>
                ))}
            </div>
          </div>
        )}

        {/* Students */}
        {route.students && route.students.length > 0 && (
          <div className="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 className="text-lg font-bold text-gray-800 mb-4 flex items-center">
              <Users className="w-5 h-5 mr-2" />
              Assigned Students ({route.students.length})
            </h2>
            <div className="space-y-2">
              {route.students.map((student) => (
                <div key={student.id} className="p-3 bg-gray-50 rounded-lg">
                  <p className="font-medium text-gray-800">{student.full_name}</p>
                  <p className="text-sm text-gray-600">{student.student_number}</p>
                </div>
              ))}
            </div>
          </div>
        )}

        {/* Today's Trips */}
        <div className="bg-white rounded-lg shadow-md p-6">
          <h2 className="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <Calendar className="w-5 h-5 mr-2" />
            Today's Trips
          </h2>
          <div className="space-y-3">
            {route.morning_pickup_time && (
              <button
                onClick={() => navigate(`/trips/new?route=${route.id}&type=morning_pickup`)}
                className="w-full p-4 bg-blue-50 hover:bg-blue-100 rounded-lg text-left transition"
              >
                <div className="flex items-center justify-between">
                  <div>
                    <p className="font-medium text-gray-800">Morning Pickup</p>
                    <p className="text-sm text-gray-600">{route.morning_pickup_time}</p>
                  </div>
                  <Clock className="w-5 h-5 text-blue-600" />
                </div>
              </button>
            )}
            {route.morning_dropoff_time && (
              <button
                onClick={() => navigate(`/trips/new?route=${route.id}&type=morning_dropoff`)}
                className="w-full p-4 bg-green-50 hover:bg-green-100 rounded-lg text-left transition"
              >
                <div className="flex items-center justify-between">
                  <div>
                    <p className="font-medium text-gray-800">Morning Dropoff</p>
                    <p className="text-sm text-gray-600">{route.morning_dropoff_time}</p>
                  </div>
                  <Clock className="w-5 h-5 text-green-600" />
                </div>
              </button>
            )}
            {route.afternoon_pickup_time && (
              <button
                onClick={() => navigate(`/trips/new?route=${route.id}&type=afternoon_pickup`)}
                className="w-full p-4 bg-orange-50 hover:bg-orange-100 rounded-lg text-left transition"
              >
                <div className="flex items-center justify-between">
                  <div>
                    <p className="font-medium text-gray-800">Afternoon Pickup</p>
                    <p className="text-sm text-gray-600">{route.afternoon_pickup_time}</p>
                  </div>
                  <Clock className="w-5 h-5 text-orange-600" />
                </div>
              </button>
            )}
            {route.afternoon_dropoff_time && (
              <button
                onClick={() => navigate(`/trips/new?route=${route.id}&type=afternoon_dropoff`)}
                className="w-full p-4 bg-purple-50 hover:bg-purple-100 rounded-lg text-left transition"
              >
                <div className="flex items-center justify-between">
                  <div>
                    <p className="font-medium text-gray-800">Afternoon Dropoff</p>
                    <p className="text-sm text-gray-600">{route.afternoon_dropoff_time}</p>
                  </div>
                  <Clock className="w-5 h-5 text-purple-600" />
                </div>
              </button>
            )}
          </div>
        </div>
      </main>
    </div>
  );
}


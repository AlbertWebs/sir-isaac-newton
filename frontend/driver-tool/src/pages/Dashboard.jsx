import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { Bus, MapPin, Clock, LogOut, RefreshCw } from 'lucide-react';
import { getMyRoutes } from '../services/transport';
import { logout } from '../services/auth';

export default function Dashboard({ user }) {
  const [routes, setRoutes] = useState([]);
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);
  const navigate = useNavigate();

  useEffect(() => {
    loadRoutes();
  }, []);

  const loadRoutes = async () => {
    try {
      const data = await getMyRoutes();
      setRoutes(data);
    } catch (error) {
      console.error('Error loading routes:', error);
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  const handleRefresh = () => {
    setRefreshing(true);
    loadRoutes();
  };

  const handleLogout = async () => {
    await logout();
    navigate('/login');
  };

  const getTodayTrips = (route) => {
    const today = new Date().toISOString().split('T')[0];
    // This would come from the API - for now return mock data
    return [
      { id: 1, type: 'morning_pickup', time: route.morning_pickup_time, status: 'scheduled' },
      { id: 2, type: 'morning_dropoff', time: route.morning_dropoff_time, status: 'scheduled' },
      { id: 3, type: 'afternoon_pickup', time: route.afternoon_pickup_time, status: 'scheduled' },
      { id: 4, type: 'afternoon_dropoff', time: route.afternoon_dropoff_time, status: 'scheduled' },
    ].filter(trip => trip.time);
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-lg">Loading routes...</div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <header className="bg-blue-600 text-white shadow-lg">
        <div className="max-w-7xl mx-auto px-4 py-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center space-x-3">
              <Bus className="w-8 h-8" />
              <div>
                <h1 className="text-xl font-bold">Driver Dashboard</h1>
                <p className="text-sm text-blue-100">Welcome, {user?.name}</p>
              </div>
            </div>
            <button
              onClick={handleLogout}
              className="flex items-center space-x-2 px-4 py-2 bg-blue-700 hover:bg-blue-800 rounded-lg transition"
            >
              <LogOut className="w-4 h-4" />
              <span>Logout</span>
            </button>
          </div>
        </div>
      </header>

      {/* Main Content */}
      <main className="max-w-7xl mx-auto px-4 py-6">
        <div className="flex items-center justify-between mb-6">
          <h2 className="text-2xl font-bold text-gray-800">My Routes</h2>
          <button
            onClick={handleRefresh}
            disabled={refreshing}
            className="flex items-center space-x-2 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50"
          >
            <RefreshCw className={`w-4 h-4 ${refreshing ? 'animate-spin' : ''}`} />
            <span>Refresh</span>
          </button>
        </div>

        {routes.length === 0 ? (
          <div className="bg-white rounded-lg shadow p-8 text-center">
            <Bus className="w-16 h-16 text-gray-400 mx-auto mb-4" />
            <p className="text-gray-600">No routes assigned</p>
          </div>
        ) : (
          <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            {routes.map((route) => {
              const trips = getTodayTrips(route);
              return (
                <div
                  key={route.id}
                  className="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition"
                >
                  <div className="flex items-start justify-between mb-4">
                    <div>
                      <h3 className="text-lg font-bold text-gray-800">{route.name}</h3>
                      <p className="text-sm text-gray-600">{route.code}</p>
                    </div>
                    <span className={`px-2 py-1 text-xs rounded ${
                      route.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'
                    }`}>
                      {route.status}
                    </span>
                  </div>

                  {route.vehicle && (
                    <div className="mb-4">
                      <p className="text-sm text-gray-600">
                        <Bus className="w-4 h-4 inline mr-1" />
                        {route.vehicle.registration_number} - {route.vehicle.make} {route.vehicle.model}
                      </p>
                    </div>
                  )}

                  {route.stops && route.stops.length > 0 && (
                    <div className="mb-4">
                      <p className="text-sm text-gray-600 mb-2">
                        <MapPin className="w-4 h-4 inline mr-1" />
                        {route.stops.length} stops
                      </p>
                    </div>
                  )}

                  {trips.length > 0 && (
                    <div className="mb-4">
                      <p className="text-sm font-medium text-gray-700 mb-2">Today's Trips:</p>
                      <div className="space-y-2">
                        {trips.map((trip) => (
                          <div key={trip.id} className="flex items-center justify-between text-sm">
                            <span className="text-gray-600 capitalize">
                              {trip.type.replace('_', ' ')}
                            </span>
                            <span className="flex items-center text-gray-800">
                              <Clock className="w-3 h-3 mr-1" />
                              {trip.time}
                            </span>
                          </div>
                        ))}
                      </div>
                    </div>
                  )}

                  <button
                    onClick={() => navigate(`/routes/${route.id}`)}
                    className="w-full mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-700 transition"
                  >
                    View Route Details
                  </button>
                </div>
              );
            })}
          </div>
        )}
      </main>
    </div>
  );
}


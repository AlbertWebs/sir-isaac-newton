import { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { ArrowLeft, CheckCircle, XCircle, Clock, MapPin } from 'lucide-react';
import { getTripStudents, markPickup } from '../services/transport';

export default function TripDetail({ user }) {
  const { tripId } = useParams();
  const navigate = useNavigate();
  const [tripData, setTripData] = useState(null);
  const [loading, setLoading] = useState(true);
  const [updating, setUpdating] = useState({});

  useEffect(() => {
    loadTripData();
  }, [tripId]);

  const loadTripData = async () => {
    try {
      const data = await getTripStudents(tripId);
      setTripData(data);
    } catch (error) {
      console.error('Error loading trip:', error);
    } finally {
      setLoading(false);
    }
  };

  const handleMarkStatus = async (logId, studentId, currentStatus, actionType) => {
    if (!logId) {
      alert('Pickup log not found. Please contact administrator.');
      return;
    }

    setUpdating({ ...updating, [logId]: true });

    try {
      let newStatus;
      if (actionType === 'pickup') {
        newStatus = currentStatus === 'picked' ? 'pending' : 'picked';
      } else {
        newStatus = currentStatus === 'dropped' ? 'pending' : 'dropped';
      }

      // Get current location if available
      let latitude = null;
      let longitude = null;
      
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          (position) => {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;
          },
          () => {
            console.warn('Geolocation not available');
          }
        );
      }

      await markPickup(logId, newStatus, latitude, longitude, '');
      
      // Reload trip data
      await loadTripData();
    } catch (error) {
      alert('Error updating status: ' + (error.response?.data?.message || error.message));
    } finally {
      setUpdating({ ...updating, [logId]: false });
    }
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-lg">Loading trip...</div>
      </div>
    );
  }

  if (!tripData) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-lg text-red-600">Trip not found</div>
      </div>
    );
  }

  const { trip, students } = tripData;

  const getStatusColor = (status) => {
    switch (status) {
      case 'picked':
      case 'dropped':
        return 'bg-green-100 text-green-800 border-green-300';
      case 'missed':
        return 'bg-red-100 text-red-800 border-red-300';
      case 'pending':
      default:
        return 'bg-yellow-100 text-yellow-800 border-yellow-300';
    }
  };

  const getStatusIcon = (status) => {
    switch (status) {
      case 'picked':
      case 'dropped':
        return <CheckCircle className="w-5 h-5" />;
      case 'missed':
        return <XCircle className="w-5 h-5" />;
      default:
        return <Clock className="w-5 h-5" />;
    }
  };

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <header className="bg-blue-600 text-white shadow-lg">
        <div className="max-w-7xl mx-auto px-4 py-4">
          <div className="flex items-center space-x-4">
            <button
              onClick={() => navigate(-1)}
              className="p-2 hover:bg-blue-700 rounded-lg transition"
            >
              <ArrowLeft className="w-6 h-6" />
            </button>
            <div>
              <h1 className="text-xl font-bold capitalize">
                {trip.trip_type.replace('_', ' ')}
              </h1>
              <p className="text-sm text-blue-100">
                {new Date(trip.trip_date).toLocaleDateString()} - {trip.scheduled_start_time}
              </p>
            </div>
          </div>
        </div>
      </header>

      {/* Main Content */}
      <main className="max-w-7xl mx-auto px-4 py-6">
        {/* Trip Info */}
        <div className="bg-white rounded-lg shadow-md p-6 mb-6">
          <div className="grid md:grid-cols-3 gap-4">
            <div>
              <p className="text-sm text-gray-600">Route</p>
              <p className="font-medium">{trip.route?.name}</p>
            </div>
            <div>
              <p className="text-sm text-gray-600">Status</p>
              <span className={`px-2 py-1 text-xs rounded ${
                trip.status === 'completed' ? 'bg-green-100 text-green-800' :
                trip.status === 'in_progress' ? 'bg-blue-100 text-blue-800' :
                'bg-gray-100 text-gray-800'
              }`}>
                {trip.status}
              </span>
            </div>
            <div>
              <p className="text-sm text-gray-600">Students</p>
              <p className="font-medium">{students.length}</p>
            </div>
          </div>
        </div>

        {/* Student Checklist */}
        <div className="bg-white rounded-lg shadow-md p-6">
          <h2 className="text-lg font-bold text-gray-800 mb-4">Student Checklist</h2>
          
          {students.length === 0 ? (
            <p className="text-gray-600 text-center py-8">No students assigned to this trip</p>
          ) : (
            <div className="space-y-3">
              {students.map((student) => {
                const isPickup = trip.trip_type.includes('pickup');
                const actionType = isPickup ? 'pickup' : 'dropoff';
                const canMark = student.pickup_status === 'pending' || 
                               (isPickup && student.pickup_status !== 'picked') ||
                               (!isPickup && student.pickup_status !== 'dropped');

                return (
                  <div
                    key={student.id}
                    className={`p-4 rounded-lg border-2 ${
                      student.pickup_status === 'picked' || student.pickup_status === 'dropped'
                        ? 'bg-green-50 border-green-300'
                        : 'bg-white border-gray-200'
                    }`}
                  >
                    <div className="flex items-center justify-between">
                      <div className="flex-1">
                        <p className="font-medium text-gray-800">{student.name}</p>
                        <p className="text-sm text-gray-600">{student.student_number}</p>
                        <div className="mt-2">
                          <span className={`inline-flex items-center px-2 py-1 rounded text-xs font-medium ${getStatusColor(student.pickup_status)}`}>
                            {getStatusIcon(student.pickup_status)}
                            <span className="ml-1 capitalize">{student.pickup_status}</span>
                          </span>
                        </div>
                      </div>
                      
                      <div className="ml-4">
                        {canMark ? (
                          <button
                            onClick={() => handleMarkStatus(
                              student.pickup_log_id,
                              student.id,
                              student.pickup_status,
                              actionType
                            )}
                            disabled={updating[student.pickup_log_id]}
                            className={`px-4 py-2 rounded-lg font-medium transition ${
                              isPickup
                                ? 'bg-blue-600 text-white hover:bg-blue-700'
                                : 'bg-green-600 text-white hover:bg-green-700'
                            } disabled:opacity-50`}
                          >
                            {updating[student.pickup_log_id] ? (
                              'Updating...'
                            ) : (
                              isPickup ? 'Mark Picked' : 'Mark Dropped'
                            )}
                          </button>
                        ) : (
                          <div className="flex items-center text-green-600">
                            <CheckCircle className="w-5 h-5 mr-1" />
                            <span className="text-sm font-medium">Done</span>
                          </div>
                        )}
                      </div>
                    </div>
                  </div>
                );
              })}
            </div>
          )}
        </div>
      </main>
    </div>
  );
}


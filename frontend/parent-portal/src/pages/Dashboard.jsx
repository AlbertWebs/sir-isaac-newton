import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { Users, Bell, FileText, Bus, LogOut, Calendar, TrendingUp } from 'lucide-react';
import { getMyChildren } from '../services/students';
import { getUnreadNotifications } from '../services/notifications';
import { logout } from '../services/auth';

export default function Dashboard({ user }) {
  const [children, setChildren] = useState([]);
  const [notifications, setNotifications] = useState([]);
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {
    loadData();
  }, []);

  const loadData = async () => {
    try {
      const [childrenData, notificationsData] = await Promise.all([
        getMyChildren(),
        getUnreadNotifications(),
      ]);
      setChildren(childrenData.data || childrenData);
      setNotifications(notificationsData);
    } catch (error) {
      console.error('Error loading data:', error);
    } finally {
      setLoading(false);
    }
  };

  const handleLogout = async () => {
    await logout();
    navigate('/login');
  };

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-lg">Loading...</div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <header className="bg-green-600 text-white shadow-lg">
        <div className="max-w-7xl mx-auto px-4 py-4">
          <div className="flex items-center justify-between">
            <div>
              <h1 className="text-xl font-bold">Parent Portal</h1>
              <p className="text-sm text-green-100">Welcome, {user?.name}</p>
            </div>
            <div className="flex items-center space-x-4">
              <button
                onClick={() => navigate('/notifications')}
                className="relative p-2 hover:bg-green-700 rounded-lg transition"
              >
                <Bell className="w-6 h-6" />
                {notifications.length > 0 && (
                  <span className="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                    {notifications.length}
                  </span>
                )}
              </button>
              <button
                onClick={handleLogout}
                className="flex items-center space-x-2 px-4 py-2 bg-green-700 hover:bg-green-800 rounded-lg transition"
              >
                <LogOut className="w-4 h-4" />
                <span>Logout</span>
              </button>
            </div>
          </div>
        </div>
      </header>

      {/* Main Content */}
      <main className="max-w-7xl mx-auto px-4 py-6">
        {/* Quick Stats */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
          <div className="bg-white rounded-lg shadow p-6">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-sm text-gray-600">Children</p>
                <p className="text-2xl font-bold text-gray-800">{children.length}</p>
              </div>
              <Users className="w-8 h-8 text-green-600" />
            </div>
          </div>
          <div className="bg-white rounded-lg shadow p-6">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-sm text-gray-600">Unread Notifications</p>
                <p className="text-2xl font-bold text-gray-800">{notifications.length}</p>
              </div>
              <Bell className="w-8 h-8 text-blue-600" />
            </div>
          </div>
          <div className="bg-white rounded-lg shadow p-6">
            <div className="flex items-center justify-between">
              <div>
                <p className="text-sm text-gray-600">Announcements</p>
                <p className="text-2xl font-bold text-gray-800">-</p>
              </div>
              <FileText className="w-8 h-8 text-purple-600" />
            </div>
          </div>
        </div>

        {/* Children List */}
        <div className="bg-white rounded-lg shadow-md p-6 mb-6">
          <h2 className="text-xl font-bold text-gray-800 mb-4">My Children</h2>
          
          {children.length === 0 ? (
            <p className="text-gray-600 text-center py-8">No children found</p>
          ) : (
            <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
              {children.map((child) => (
                <div
                  key={child.id}
                  onClick={() => navigate(`/students/${child.id}`)}
                  className="p-4 border border-gray-200 rounded-lg hover:shadow-md cursor-pointer transition"
                >
                  <div className="flex items-center space-x-3 mb-3">
                    <div className="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                      <Users className="w-6 h-6 text-green-600" />
                    </div>
                    <div>
                      <p className="font-medium text-gray-800">{child.full_name}</p>
                      <p className="text-sm text-gray-600">{child.student_number}</p>
                    </div>
                  </div>
                  <div className="space-y-2">
                    <div className="flex items-center text-sm text-gray-600">
                      <Calendar className="w-4 h-4 mr-2" />
                      {child.level_of_education || 'N/A'}
                    </div>
                    {child.uses_transport && (
                      <div className="flex items-center text-sm text-green-600">
                        <Bus className="w-4 h-4 mr-2" />
                        Uses Transport
                      </div>
                    )}
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>

        {/* Quick Actions */}
        <div className="bg-white rounded-lg shadow-md p-6">
          <h2 className="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
          <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <button
              onClick={() => navigate('/announcements')}
              className="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-left transition"
            >
              <FileText className="w-6 h-6 text-purple-600 mb-2" />
              <p className="font-medium text-gray-800">Announcements</p>
              <p className="text-sm text-gray-600">View school announcements</p>
            </button>
            <button
              onClick={() => navigate('/notifications')}
              className="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 text-left transition"
            >
              <Bell className="w-6 h-6 text-blue-600 mb-2" />
              <p className="font-medium text-gray-800">Notifications</p>
              <p className="text-sm text-gray-600">View all notifications</p>
            </button>
          </div>
        </div>
      </main>
    </div>
  );
}


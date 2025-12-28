import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { GraduationCap, Users, Calendar, FileText, LogOut, BookOpen } from 'lucide-react';
import { getClasses } from '../services/academics';
import { logout } from '../services/auth';

export default function Dashboard({ user }) {
  const [classes, setClasses] = useState([]);
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {
    loadClasses();
  }, []);

  const loadClasses = async () => {
    try {
      const data = await getClasses();
      setClasses(data);
    } catch (error) {
      console.error('Error loading classes:', error);
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
      <header className="bg-purple-600 text-white shadow-lg">
        <div className="max-w-7xl mx-auto px-4 py-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center space-x-3">
              <GraduationCap className="w-8 h-8" />
              <div>
                <h1 className="text-xl font-bold">Teacher Dashboard</h1>
                <p className="text-sm text-purple-100">Welcome, {user?.name}</p>
              </div>
            </div>
            <button
              onClick={handleLogout}
              className="flex items-center space-x-2 px-4 py-2 bg-purple-700 hover:bg-purple-800 rounded-lg transition"
            >
              <LogOut className="w-4 h-4" />
              <span>Logout</span>
            </button>
          </div>
        </div>
      </header>

      {/* Main Content */}
      <main className="max-w-7xl mx-auto px-4 py-6">
        {/* Quick Actions */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
          <button
            onClick={() => navigate('/attendance')}
            className="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition text-left"
          >
            <Users className="w-8 h-8 text-blue-600 mb-3" />
            <h3 className="font-bold text-gray-800 mb-1">Mark Attendance</h3>
            <p className="text-sm text-gray-600">Record student attendance</p>
          </button>
          <button
            onClick={() => navigate('/results')}
            className="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition text-left"
          >
            <FileText className="w-8 h-8 text-green-600 mb-3" />
            <h3 className="font-bold text-gray-800 mb-1">Enter Results</h3>
            <p className="text-sm text-gray-600">Post exam results</p>
          </button>
          <div className="bg-white rounded-lg shadow-md p-6">
            <Calendar className="w-8 h-8 text-purple-600 mb-3" />
            <h3 className="font-bold text-gray-800 mb-1">Timetable</h3>
            <p className="text-sm text-gray-600">View class schedule</p>
          </div>
        </div>

        {/* My Classes */}
        <div className="bg-white rounded-lg shadow-md p-6">
          <h2 className="text-xl font-bold text-gray-800 mb-4">My Classes</h2>
          
          {classes.length === 0 ? (
            <p className="text-gray-600 text-center py-8">No classes assigned</p>
          ) : (
            <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
              {classes.map((classItem) => (
                <div
                  key={classItem.id}
                  onClick={() => navigate(`/classes/${classItem.id}`)}
                  className="p-4 border border-gray-200 rounded-lg hover:shadow-md cursor-pointer transition"
                >
                  <div className="flex items-center justify-between mb-2">
                    <h3 className="font-bold text-gray-800">{classItem.name}</h3>
                    <span className={`px-2 py-1 text-xs rounded ${
                      classItem.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'
                    }`}>
                      {classItem.status}
                    </span>
                  </div>
                  <p className="text-sm text-gray-600 mb-2">{classItem.code}</p>
                  <div className="flex items-center text-sm text-gray-600">
                    <Users className="w-4 h-4 mr-1" />
                    {classItem.current_enrollment || 0} students
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>
      </main>
    </div>
  );
}


import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import { useState, useEffect } from 'react';
import Login from './pages/Login';
import Dashboard from './pages/Dashboard';
import StudentDetail from './pages/StudentDetail';
import Announcements from './pages/Announcements';
import Notifications from './pages/Notifications';
import { getAuthToken } from './config/api';
import { getCurrentUser } from './services/auth';

function App() {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const token = getAuthToken();
    if (token) {
      getCurrentUser()
        .then(setUser)
        .catch(() => {
          localStorage.removeItem('parent_token');
        })
        .finally(() => setLoading(false));
    } else {
      setLoading(false);
    }
  }, []);

  if (loading) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <div className="text-lg">Loading...</div>
      </div>
    );
  }

  return (
    <Router>
      <Routes>
        <Route
          path="/login"
          element={user ? <Navigate to="/" replace /> : <Login setUser={setUser} />}
        />
        <Route
          path="/"
          element={user ? <Dashboard user={user} /> : <Navigate to="/login" replace />}
        />
        <Route
          path="/students/:id"
          element={user ? <StudentDetail user={user} /> : <Navigate to="/login" replace />}
        />
        <Route
          path="/announcements"
          element={user ? <Announcements user={user} /> : <Navigate to="/login" replace />}
        />
        <Route
          path="/notifications"
          element={user ? <Notifications user={user} /> : <Navigate to="/login" replace />}
        />
      </Routes>
    </Router>
  );
}

export default App;


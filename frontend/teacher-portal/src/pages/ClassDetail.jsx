import { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { ArrowLeft, Users, Calendar, BookOpen } from 'lucide-react';
import api from '../services/api';

export default function ClassDetail({ user }) {
  const { id } = useParams();
  const navigate = useNavigate();
  const [classItem, setClassItem] = useState(null);
  const [students, setStudents] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    loadClassData();
  }, [id]);

  const loadClassData = async () => {
    try {
      const response = await api.get(`/academics/classes/${id}`);
      setClassItem(response.data);
      // Load students for this class
      const studentsResponse = await api.get(`/students?class_id=${id}`);
      setStudents(studentsResponse.data.data || studentsResponse.data);
    } catch (error) {
      console.error('Error loading class:', error);
    } finally {
      setLoading(false);
    }
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
      <header className="bg-purple-600 text-white shadow-lg">
        <div className="max-w-7xl mx-auto px-4 py-4">
          <div className="flex items-center space-x-4">
            <button
              onClick={() => navigate('/')}
              className="p-2 hover:bg-purple-700 rounded-lg transition"
            >
              <ArrowLeft className="w-6 h-6" />
            </button>
            <div>
              <h1 className="text-xl font-bold">{classItem?.name}</h1>
              <p className="text-sm text-purple-100">{classItem?.code}</p>
            </div>
          </div>
        </div>
      </header>

      <main className="max-w-7xl mx-auto px-4 py-6">
        <div className="bg-white rounded-lg shadow-md p-6 mb-6">
          <h2 className="text-lg font-bold text-gray-800 mb-4">Class Information</h2>
          <div className="grid md:grid-cols-2 gap-4">
            <div>
              <p className="text-sm text-gray-600">Level</p>
              <p className="font-medium capitalize">{classItem?.level?.replace('_', ' ') || 'N/A'}</p>
            </div>
            <div>
              <p className="text-sm text-gray-600">Academic Year</p>
              <p className="font-medium">{classItem?.academic_year || 'N/A'}</p>
            </div>
            <div>
              <p className="text-sm text-gray-600">Class Teacher</p>
              <p className="font-medium">{classItem?.class_teacher?.full_name || 'Not assigned'}</p>
            </div>
            <div>
              <p className="text-sm text-gray-600">Enrollment</p>
              <p className="font-medium">{classItem?.current_enrollment || 0} / {classItem?.capacity || 0}</p>
            </div>
          </div>
        </div>

        <div className="bg-white rounded-lg shadow-md p-6">
          <div className="flex items-center justify-between mb-4">
            <h2 className="text-lg font-bold text-gray-800 flex items-center">
              <Users className="w-5 h-5 mr-2" />
              Students ({students.length})
            </h2>
            <button
              onClick={() => navigate('/attendance')}
              className="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700"
            >
              Mark Attendance
            </button>
          </div>
          {students.length === 0 ? (
            <p className="text-gray-600 text-center py-8">No students in this class</p>
          ) : (
            <div className="space-y-2">
              {students.map((student) => (
                <div key={student.id} className="p-3 bg-gray-50 rounded-lg">
                  <p className="font-medium text-gray-800">{student.full_name}</p>
                  <p className="text-sm text-gray-600">{student.student_number}</p>
                </div>
              ))}
            </div>
          )}
        </div>
      </main>
    </div>
  );
}


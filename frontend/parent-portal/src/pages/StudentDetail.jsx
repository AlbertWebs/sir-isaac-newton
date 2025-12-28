import { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { ArrowLeft, Calendar, Bus, TrendingUp, FileText, Clock } from 'lucide-react';
import { getStudentDetails, getStudentAttendance, getStudentResults, getStudentTransportStatus } from '../services/students';
import { format } from 'date-fns';

export default function StudentDetail({ user }) {
  const { id } = useParams();
  const navigate = useNavigate();
  const [student, setStudent] = useState(null);
  const [attendance, setAttendance] = useState([]);
  const [results, setResults] = useState([]);
  const [transport, setTransport] = useState(null);
  const [loading, setLoading] = useState(true);
  const [activeTab, setActiveTab] = useState('overview');

  useEffect(() => {
    loadStudentData();
  }, [id]);

  const loadStudentData = async () => {
    try {
      const [studentData, attendanceData, resultsData] = await Promise.all([
        getStudentDetails(id),
        getStudentAttendance(id),
        getStudentResults(id),
      ]);

      setStudent(studentData);
      setAttendance(attendanceData);
      setResults(resultsData);

      if (studentData.uses_transport) {
        try {
          const transportData = await getStudentTransportStatus(id);
          setTransport(transportData);
        } catch (error) {
          console.error('Error loading transport:', error);
        }
      }
    } catch (error) {
      console.error('Error loading student data:', error);
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

  if (!student) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-lg text-red-600">Student not found</div>
      </div>
    );
  }

  const attendanceStats = {
    present: attendance.filter(a => a.status === 'present').length,
    absent: attendance.filter(a => a.status === 'absent').length,
    late: attendance.filter(a => a.status === 'late').length,
    total: attendance.length,
  };

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <header className="bg-green-600 text-white shadow-lg">
        <div className="max-w-7xl mx-auto px-4 py-4">
          <div className="flex items-center space-x-4">
            <button
              onClick={() => navigate('/')}
              className="p-2 hover:bg-green-700 rounded-lg transition"
            >
              <ArrowLeft className="w-6 h-6" />
            </button>
            <div>
              <h1 className="text-xl font-bold">{student.full_name}</h1>
              <p className="text-sm text-green-100">{student.student_number}</p>
            </div>
          </div>
        </div>
      </header>

      {/* Main Content */}
      <main className="max-w-7xl mx-auto px-4 py-6">
        {/* Tabs */}
        <div className="bg-white rounded-lg shadow-md mb-6">
          <div className="border-b border-gray-200">
            <nav className="flex -mb-px">
              {['overview', 'attendance', 'results', 'transport'].map((tab) => (
                <button
                  key={tab}
                  onClick={() => setActiveTab(tab)}
                  className={`px-6 py-3 text-sm font-medium capitalize border-b-2 transition ${
                    activeTab === tab
                      ? 'border-green-600 text-green-600'
                      : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                  }`}
                >
                  {tab}
                </button>
              ))}
            </nav>
          </div>

          <div className="p-6">
            {/* Overview Tab */}
            {activeTab === 'overview' && (
              <div className="space-y-6">
                <div>
                  <h3 className="text-lg font-bold text-gray-800 mb-4">Student Information</h3>
                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <p className="text-sm text-gray-600">Level</p>
                      <p className="font-medium">{student.level_of_education || 'N/A'}</p>
                    </div>
                    <div>
                      <p className="text-sm text-gray-600">Status</p>
                      <span className={`px-2 py-1 text-xs rounded ${
                        student.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'
                      }`}>
                        {student.status}
                      </span>
                    </div>
                  </div>
                </div>

                {attendanceStats.total > 0 && (
                  <div>
                    <h3 className="text-lg font-bold text-gray-800 mb-4">Attendance Summary</h3>
                    <div className="grid grid-cols-4 gap-4">
                      <div className="bg-green-50 p-4 rounded-lg">
                        <p className="text-sm text-gray-600">Present</p>
                        <p className="text-2xl font-bold text-green-600">{attendanceStats.present}</p>
                      </div>
                      <div className="bg-red-50 p-4 rounded-lg">
                        <p className="text-sm text-gray-600">Absent</p>
                        <p className="text-2xl font-bold text-red-600">{attendanceStats.absent}</p>
                      </div>
                      <div className="bg-yellow-50 p-4 rounded-lg">
                        <p className="text-sm text-gray-600">Late</p>
                        <p className="text-2xl font-bold text-yellow-600">{attendanceStats.late}</p>
                      </div>
                      <div className="bg-blue-50 p-4 rounded-lg">
                        <p className="text-sm text-gray-600">Total</p>
                        <p className="text-2xl font-bold text-blue-600">{attendanceStats.total}</p>
                      </div>
                    </div>
                  </div>
                )}
              </div>
            )}

            {/* Attendance Tab */}
            {activeTab === 'attendance' && (
              <div>
                <h3 className="text-lg font-bold text-gray-800 mb-4">Attendance Records</h3>
                {attendance.length === 0 ? (
                  <p className="text-gray-600">No attendance records found</p>
                ) : (
                  <div className="space-y-2">
                    {attendance.map((record) => (
                      <div key={record.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                          <p className="font-medium">{format(new Date(record.attendance_date), 'MMM dd, yyyy')}</p>
                          <p className="text-sm text-gray-600">{record.course?.name || 'N/A'}</p>
                        </div>
                        <span className={`px-3 py-1 text-xs rounded font-medium ${
                          record.status === 'present' ? 'bg-green-100 text-green-800' :
                          record.status === 'absent' ? 'bg-red-100 text-red-800' :
                          record.status === 'late' ? 'bg-yellow-100 text-yellow-800' :
                          'bg-gray-100 text-gray-800'
                        }`}>
                          {record.status}
                        </span>
                      </div>
                    ))}
                  </div>
                )}
              </div>
            )}

            {/* Results Tab */}
            {activeTab === 'results' && (
              <div>
                <h3 className="text-lg font-bold text-gray-800 mb-4">Academic Results</h3>
                {results.length === 0 ? (
                  <p className="text-gray-600">No results found</p>
                ) : (
                  <div className="space-y-3">
                    {results.map((result) => (
                      <div key={result.id} className="p-4 bg-gray-50 rounded-lg">
                        <div className="flex items-center justify-between mb-2">
                          <p className="font-medium">{result.course?.name || 'N/A'}</p>
                          <span className="text-lg font-bold text-blue-600">{result.marks}%</span>
                        </div>
                        <div className="flex items-center space-x-4 text-sm text-gray-600">
                          <span>{result.academic_year}</span>
                          <span>{result.term}</span>
                          <span>{result.exam_type}</span>
                          {result.grade && <span className="font-medium">{result.grade}</span>}
                        </div>
                      </div>
                    ))}
                  </div>
                )}
              </div>
            )}

            {/* Transport Tab */}
            {activeTab === 'transport' && (
              <div>
                <h3 className="text-lg font-bold text-gray-800 mb-4">Transport Information</h3>
                {!student.uses_transport ? (
                  <p className="text-gray-600">Student does not use transport</p>
                ) : transport ? (
                  <div className="space-y-4">
                    {transport.assignment && (
                      <div className="p-4 bg-blue-50 rounded-lg">
                        <p className="font-medium mb-2">Assigned Route</p>
                        <p className="text-gray-700">{transport.assignment.route?.name}</p>
                        <p className="text-sm text-gray-600 mt-1">
                          Service: {transport.assignment.service_type}
                        </p>
                      </div>
                    )}
                    {transport.today_logs && transport.today_logs.length > 0 && (
                      <div>
                        <p className="font-medium mb-2">Today's Status</p>
                        <div className="space-y-2">
                          {transport.today_logs.map((log) => (
                            <div key={log.id} className="p-3 bg-white border border-gray-200 rounded-lg">
                              <div className="flex items-center justify-between">
                                <span className="capitalize">{log.action_type}</span>
                                <span className={`px-2 py-1 text-xs rounded ${
                                  log.status === 'picked' || log.status === 'dropped' ? 'bg-green-100 text-green-800' :
                                  log.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                  'bg-red-100 text-red-800'
                                }`}>
                                  {log.status}
                                </span>
                              </div>
                              {log.actual_time && (
                                <p className="text-sm text-gray-600 mt-1">
                                  {format(new Date(log.actual_time), 'hh:mm a')}
                                </p>
                              )}
                            </div>
                          ))}
                        </div>
                      </div>
                    )}
                  </div>
                ) : (
                  <p className="text-gray-600">Loading transport information...</p>
                )}
              </div>
            )}
          </div>
        </div>
      </main>
    </div>
  );
}


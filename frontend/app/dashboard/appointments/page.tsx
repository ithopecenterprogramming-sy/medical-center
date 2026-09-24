import ProtectedRoute from '@/components/ProtectedRoute';

export default function AppointmentsPage() {
  return (
    <ProtectedRoute allowedRoles={['admin', 'receptionist']}>
      <div>إدارة الحجوزات والمواعيد</div>
    </ProtectedRoute>
  );
}
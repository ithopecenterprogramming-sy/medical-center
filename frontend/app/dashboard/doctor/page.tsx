import ProtectedRoute from '@/components/ProtectedRoute';

export default function DoctorPage() {
  return (
    <ProtectedRoute allowedRoles={['doctor']}>
      <div>صفحة تشخيص المرضى والوصفات الطبية</div>
    </ProtectedRoute>
  );
}
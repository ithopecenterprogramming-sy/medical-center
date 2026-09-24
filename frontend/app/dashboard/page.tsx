import ProtectedRoute from '@/components/ProtectedRoute';

export default function DashboardPage() {
  return (
    <ProtectedRoute>
      <div>مرحباً بك في لوحة التحكم الرئيسية</div>
    </ProtectedRoute>
  );
}
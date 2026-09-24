'use client';

import { useAuth } from '@/context/AuthContext';
import { useRouter } from 'next/navigation';
import { useEffect } from 'react';

interface ProtectedRouteProps {
  children: React.ReactNode;
  allowedRoles?: ('admin' | 'doctor' | 'receptionist')[];
}

export default function ProtectedRoute({ children, allowedRoles }: ProtectedRouteProps) {
  const { user, loading } = useAuth();
  const router = useRouter();

  useEffect(() => {
    if (!loading) {
      // 1. إذا لم يكن المستخدم مسجلاً، وجهه لصفحة الدخول
      if (!user) {
        router.push('/login');
        return;
      }

      // 2. إذا كانت الصفحة تتطلب أدواراً محدودة والمستخدم لا يملك أحدها، وجهه لصفحة غير مصرح بها أو للوحة التحكم
      if (allowedRoles && !allowedRoles.includes(user.role)) {
        router.push('/unauthorized'); // أو يمكن توجيهه للـ /dashboard
      }
    }
  }, [user, loading, allowedRoles, router]);

  // أثناء شاشة التحميل الأولية لا نعرض المحتوى
  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-slate-950 text-white">
        <div className="flex items-center gap-3">
          <span className="w-6 h-6 border-2 border-amber-500 border-t-transparent rounded-full animate-spin" />
          <span className="text-sm font-medium">جاري التحقق من الصلاحيات...</span>
        </div>
      </div>
    );
  }

  // إذا كان غير مسجل أو لا يملك الصلاحية، نمنع عرض الصفحة لحين اكتمال التوجيه
  if (!user || (allowedRoles && !allowedRoles.includes(user.role))) {
    return null;
  }

  return <>{children}</>;
}
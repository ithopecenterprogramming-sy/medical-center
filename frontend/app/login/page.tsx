'use client';

import { useState, useEffect } from 'react';
import { useRouter, useSearchParams } from 'next/navigation';
import { useAuth } from '@/context/AuthContext';
import { motion, AnimatePresence } from 'framer-motion';
import Link from 'next/link';

export default function LoginPage() {
  const router = useRouter();
  const searchParams = useSearchParams();
  const { login, user, loading } = useAuth();

  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [errorMsg, setErrorMsg] = useState<string | null>(null);
  const [sessionExpiredMsg, setSessionExpiredMsg] = useState<boolean>(false);

  // 1. حالة العداد التنازلي (بالثواني)
  const [lockoutTime, setLockoutTime] = useState<number>(0);

  // إذا كان المستخدم مسجلاً بالفعل، نعيده للوحة التحكم
  useEffect(() => {
    if (!loading && user) {
      router.push('/dashboard');
    }
  }, [user, loading, router]);
// فحص وقت الحظر المخزن عند فتح الصفحة أو عمل Refresh
useEffect(() => {
  const savedExpiry = localStorage.getItem('login_lockout_expiry');
  if (savedExpiry) {
    const remainingSeconds = Math.ceil((parseInt(savedExpiry, 10) - Date.now()) / 1000);
    if (remainingSeconds > 0) {
      setLockoutTime(remainingSeconds);
      setErrorMsg('محاولات كثيرة متكررة، يرجى الانتظار حتى انتهاء العداد لإعادة المحاولة.');
    } else {
      localStorage.removeItem('login_lockout_expiry');
    }
  }
}, []);
  // فحص الرابط بحثاً عن expired=1
  useEffect(() => {
    if (searchParams.get('expired') === '1') {
      setSessionExpiredMsg(true);
      router.replace('/login');
    }
  }, [searchParams, router]);

  // 2. محرك العداد التنازلي للخصم كل ثانية
  useEffect(() => {
    if (lockoutTime <= 0) return;

    const timer = setInterval(() => {
      setLockoutTime((prev) => {
        if (prev <= 1) {
          setErrorMsg(null); // مسح رسالة القفل عند انتهاء الوقت
          return 0;
        }
        return prev - 1;
      });
    }, 1000);

    return () => clearInterval(timer);
  }, [lockoutTime]);

  // دالة تحويل الثواني إلى صيغة (MM:SS)
  const formatTime = (seconds: number) => {
    const mins = Math.floor(seconds / 60);
    const secs = seconds % 60;
    return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
  };

 const handleSubmit = async (e: React.FormEvent) => {
  e.preventDefault();
  if (lockoutTime > 0 || isSubmitting) return;

  setErrorMsg(null);
  setSessionExpiredMsg(false);
  setIsSubmitting(true);

  try {
    await login({ email, password });
  } catch (error: any) {
    // إيقاف حالة التحميل فوراً داخل catch
    setIsSubmitting(false);

    const status = error.response?.status;

    if (status === 429) {
      const retryAfterHeader = error.response?.headers?.['retry-after'];
      const secondsLeft = retryAfterHeader ? parseInt(retryAfterHeader, 10) : 300;

      const expiryTime = Date.now() + secondsLeft * 1000;
      localStorage.setItem('login_lockout_expiry', expiryTime.toString());

      setLockoutTime(secondsLeft);
      setErrorMsg('محاولات كثيرة متكررة، يرجى الانتظار حتى انتهاء العداد لإعادة المحاولة.');
    } else if (status === 422 || status === 401) {
      setErrorMsg('البريد الإلكتروني أو كلمة المرور غير صحيحة.');
    } else {
      setErrorMsg('حدث خطأ في الاتصال، يرجى المحاولة لاحقاً.');
    }
  } finally {
    // التأكيد الإضافي لإنهاء التحميل
    setIsSubmitting(false);
  }
};
  if (loading) return null;

  return (
    <div className="min-h-screen bg-slate-100/70 dark:bg-slate-950 flex flex-col justify-center py-12 sm:px-6 lg:px-8 transition-colors duration-300">
      <div className="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 className="mt-6 text-center text-3xl font-black text-slate-900 dark:text-white">
          تسجيل الدخول
        </h2>
        <p className="mt-2 text-center text-sm text-slate-500 dark:text-slate-400">
          بوابة الإدارة الطبية المتكاملة
        </p>
      </div>

      <div className="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div className="bg-white dark:bg-slate-900 py-8 px-4 shadow-xl shadow-amber-500/5 dark:shadow-none sm:rounded-3xl sm:px-10 border border-slate-200 dark:border-slate-800">
          
          <AnimatePresence>
            {/* تنبيه انتهاء الجلسة */}
            {sessionExpiredMsg && (
              <motion.div
                initial={{ opacity: 0, y: -10 }}
                animate={{ opacity: 1, y: 0 }}
                exit={{ opacity: 0 }}
                className="mb-6 p-4 rounded-xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 flex items-start gap-3"
              >
                <span className="text-amber-500 mt-0.5">⚠️</span>
                <p className="text-xs font-medium text-amber-800 dark:text-amber-500">
                  انتهت صلاحية الجلسة لدواعي أمنية. يرجى إعادة تسجيل الدخول لمتابعة عملك.
                </p>
              </motion.div>
            )}

            {/* تنبيه الخطأ مع العداد التنازلي */}
            {errorMsg && (
              <motion.div
                initial={{ opacity: 0, y: -10 }}
                animate={{ opacity: 1, y: 0 }}
                exit={{ opacity: 0 }}
                className="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-xs font-medium text-red-800 dark:text-red-500 text-center"
              >
                <div>{errorMsg}</div>
                {lockoutTime > 0 && (
                  <div className="mt-2 text-sm font-bold text-amber-500 dir-ltr">
                    ⏱️ {formatTime(lockoutTime)}
                  </div>
                )}
              </motion.div>
            )}
          </AnimatePresence>

          <form className="space-y-6" onSubmit={handleSubmit}>
            <div>
              <label className="block text-sm font-medium text-slate-700 dark:text-slate-300">
                البريد الإلكتروني
              </label>
              <div className="mt-1">
                <input
                  type="email"
                  required
                  value={email}
                  disabled={lockoutTime > 0}
                  onChange={(e) => setEmail(e.target.value)}
                  className="appearance-none block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-950 dark:text-white sm:text-sm transition-colors disabled:opacity-50"
                  placeholder="admin@example.com"
                  dir="ltr"
                />
              </div>
            </div>

            <div>
              <label className="block text-sm font-medium text-slate-700 dark:text-slate-300">
                كلمة المرور
              </label>
              <div className="mt-1">
                <input
                  type="password"
                  required
                  value={password}
                  disabled={lockoutTime > 0}
                  onChange={(e) => setPassword(e.target.value)}
                  className="appearance-none block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-950 dark:text-white sm:text-sm transition-colors disabled:opacity-50"
                  placeholder="••••••••"
                  dir="ltr"
                />
              </div>
            </div>

            {/* زر الدخول المعطل أثناء العداد */}
            <div>
              <button
                type="submit"
                disabled={isSubmitting || lockoutTime > 0}
                className="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-slate-950 bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
              >
                {isSubmitting ? (
                  <div className="flex items-center gap-2">
                    <span className="w-4 h-4 border-2 border-slate-950 border-t-transparent rounded-full animate-spin" />
                    جاري الدخول...
                  </div>
                ) : lockoutTime > 0 ? (
                  `يرجى الانتظار (${formatTime(lockoutTime)})`
                ) : (
                  'دخول للنظام'
                )}
              </button>
            </div>
          </form>

          <div className="mt-6 text-center text-xs text-slate-500">
            <Link href="/" className="hover:text-amber-500 transition-colors">
              العودة للصفحة الرئيسية &rarr;
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
}
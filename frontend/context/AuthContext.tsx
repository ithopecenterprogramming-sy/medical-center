'use client';

import React, { createContext, useContext, useState, useEffect, ReactNode } from 'react';
import { useRouter } from 'next/navigation';
import api from '@/lib/api';
import { User, AuthResponse } from '@/types/auth';

interface AuthContextType {
  user: User | null;
  loading: boolean;
  login: (credentials: Record<string, string>) => Promise<void>;
  logout: () => Promise<void>;
  isAuthenticated: boolean;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export function AuthProvider({ children }: { children: ReactNode }) {
  const [user, setUser] = useState<User | null>(null);
  const [loading, setLoading] = useState<boolean>(true);
  const router = useRouter();

  useEffect(() => {
    async function loadUserFromApi() {
      const token = localStorage.getItem('access_token');
      if (!token) {
        setLoading(false);
        return;
      }

      try {
        const response = await api.get('/auth/me');
        // للتعامل مع استجابة السيرفر سواء كانت مغلفة بـ data أو مرجعة مباشرة
        const userData = response.data?.data || response.data;
        setUser(userData);
      } catch (error) {
        console.error('فشل في استرجاع بيانات الجلسة:', error);
        localStorage.removeItem('access_token');
        setUser(null);
      } finally {
        setLoading(false);
      }
    }

    loadUserFromApi();
  }, []);
    const login = async (credentials: Record<string, string>) => {
    const response = await api.post('/auth/login', credentials);
    
    // فحص مرن: إذا كانت البيانات داخل response.data.data استخدمها، وإلا استخدم response.data مباشرة
    const resData = response.data;
    const authData = resData?.data || resData;

    if (!authData?.token || !authData?.user) {
        throw new Error('استجابة غير صالحة من الخادم');
    }

    localStorage.setItem('access_token', authData.token);
    setUser(authData.user);

    switch (authData.user.role) {
        case 'admin':
        router.push('/dashboard');
        break;
        case 'doctor':
        router.push('/dashboard');
        break;
        case 'receptionist':
        router.push('/dashboard');
        break;
        default:
        router.push('/dashboard');
    }
    };

  const logout = async () => {
    try {
      await api.post('/auth/logout');
    } catch (error) {
      console.error('خطأ أثناء تسجيل الخروج:', error);
    } finally {
      localStorage.removeItem('access_token');
      setUser(null);
      router.push('/login');
    }
  };

  return (
    <AuthContext.Provider
      value={{
        user,
        loading,
        login,
        logout,
        isAuthenticated: !!user,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error('useAuth يجب أن يُستخدم داخل AuthProvider');
  }
  return context;
}
export interface User {
  id: number;
  name: string;
  email: string;
  role: 'admin' | 'doctor' | 'receptionist';
}

export interface AuthResponse {
  message?: string;
  user: User;
  token: string;
}

export interface ApiErrorResponse {
  message: string;
  errors?: Record<string, string[]>;
}
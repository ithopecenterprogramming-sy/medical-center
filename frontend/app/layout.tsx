import type { Metadata } from 'next';
import { Readex_Pro } from 'next/font/google';
import './globals.css';
import { Providers } from './providers';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import { AuthProvider } from '@/context/AuthContext';
const primaryFont = Readex_Pro({
  subsets: ['arabic', 'latin'],
  weight: ['300', '400', '500', '600', '700'],
  variable: '--font-primary',
  display: 'swap',
});

export const metadata: Metadata = {
  title: 'المركز الطبي | إدارة متكاملة',
  description: 'النظام الذكي لإدارة المراكز الطبية',
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="ar" dir="rtl" className={primaryFont.variable} suppressHydrationWarning>
      <body className="bg-amber-50/40 dark:bg-slate-950 text-amber-950 dark:text-slate-100 flex flex-col min-h-screen font-sans selection:bg-amber-500 selection:text-slate-950 antialiased transition-colors duration-300">
        <Providers>
          {/* الهيدر المطور */}
          <Header />

          {/* محتوى الصفحات المتغير */}
          <main className="flex-grow">
            <AuthProvider>   {children}</AuthProvider>
         
          </main>

          {/* الفوتر المطور */}
          <Footer />
        </Providers>
      </body>
    </html>
  );
}
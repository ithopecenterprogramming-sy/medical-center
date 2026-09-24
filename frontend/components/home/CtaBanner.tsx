'use client';

import Link from 'next/link';
import { motion } from 'framer-motion';

export default function CtaBanner() {
  return (
    <section className="py-16 bg-amber-50/40 dark:bg-slate-950 transition-colors duration-300">
      <div className="container mx-auto px-4 sm:px-6">
        <motion.div 
          initial={{ opacity: 0, scale: 0.97 }}
          whileInView={{ opacity: 1, scale: 1 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6 }}
          className="relative rounded-3xl p-8 sm:p-14 bg-gradient-to-r from-amber-500 via-amber-500 to-amber-600 text-white dark:text-slate-950 overflow-hidden shadow-xl shadow-amber-500/10 text-center space-y-6"
        >
          <h2 className="text-3xl sm:text-5xl font-black tracking-tight leading-tight">
            هل أنت جاهز لتجربة رعاية صحية أسرع؟
          </h2>
          <p className="text-sm sm:text-base font-bold text-amber-50 dark:text-slate-950/80 max-w-xl mx-auto">
            سجل دخولك الآن للوصول إلى لوحة التحكم الخاصة بك ومتابعة مواعيدك وفحوصاتك الطبية بسهولة.
          </p>
          <div className="pt-2">
            <Link
              href="/login"
              className="inline-flex items-center gap-2 px-9 py-4 bg-amber-950 dark:bg-slate-950 hover:bg-amber-900 dark:hover:bg-slate-900 text-amber-400 font-black rounded-2xl shadow-md border border-amber-500/30 transition-all duration-300 hover:-translate-y-1 text-sm sm:text-base"
            >
              الانتقال إلى صفحة الدخول
              <span>←</span>
            </Link>
          </div>
        </motion.div>
      </div>
    </section>
  );
}
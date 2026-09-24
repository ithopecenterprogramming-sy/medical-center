'use client';

import { motion } from 'framer-motion';

const services = [
  {
    icon: '🩺',
    title: 'الاستشارات الطبية العامة',
    desc: 'عيادات مجهزة بأحدث المعدات وكوادر طبية متميزة لمتابعة كافة الحالات.',
  },
  {
    icon: '🔬',
    title: 'الفحوصات والمختبر الرقمي',
    desc: 'نتائج تحاليل دقيقة ومربوطة مباشرة بملفك الطبي الإلكتروني فور صدورها.',
  },
  {
    icon: '📅',
    title: 'حجز المواعيد الآلي',
    desc: 'نظام حجز مرن يقلل من زمن الانتظار ويضمن تنظيم الجدول الطبي بكفاءة.',
  },
  {
    icon: '🚨',
    title: 'قسم الطوارئ والرعاية السريعة',
    desc: 'جاهزية عالية واستجابة فورية لتوجيه الحالات الحرجة للرعاية المطلوبة.',
  },
];

export default function ServicesSection() {
  return (
    <section id="services" className="py-12 relative text-slate-800 dark:text-slate-100 transition-colors duration-300">
      
      <div className="container mx-auto px-4 sm:px-6 relative z-10">
        
        <motion.div 
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.5 }}
          className="text-center max-w-2xl mx-auto mb-16 space-y-4"
        >
          <div className="inline-flex items-center gap-2 bg-white/80 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 text-xs sm:text-sm font-bold px-5 py-2 rounded-full border border-amber-500/30 backdrop-blur-md shadow-sm">
            <span className="w-2 h-2 rounded-full bg-amber-500 dark:bg-amber-400 animate-pulse" />
            خدماتنا الطبية
          </div>

          <h2 className="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
            رعاية صحية متكاملة مصممة لأجلك
          </h2>
        </motion.div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          {services.map((item, idx) => (
            <motion.div
              key={idx}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.5, delay: idx * 0.1 }}
              whileHover={{ y: -6 }}
              className="p-8 rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-800 shadow-md hover:border-amber-500/50 hover:shadow-xl transition-all duration-300 group backdrop-blur-md"
            >
              <div className="w-14 h-14 rounded-2xl bg-amber-500/10 dark:bg-slate-800 border border-amber-500/20 dark:border-slate-700 text-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-slate-950 transition-all duration-300">
                {item.icon}
              </div>
              <h3 className="text-lg font-bold text-slate-900 dark:text-white mb-3">
                {item.title}
              </h3>
              <p className="text-xs sm:text-sm text-slate-700 dark:text-slate-300 font-medium leading-relaxed">
                {item.desc}
              </p>
            </motion.div>
          ))}
        </div>

      </div>
    </section>
  );
}
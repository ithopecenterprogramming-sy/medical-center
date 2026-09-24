'use client';

import { motion } from 'framer-motion';

const steps = [
  { 
    step: '01', 
    title: 'اختر العيادة أو الطبيب', 
    desc: 'استعرض الأطباء والتخصصات المتاحة بسهولة مع جدول الأوقات.' 
  },
  { 
    step: '02', 
    title: 'حدد الموعد المناسب', 
    desc: 'اختر الوقت والتاريخ الذي يناسب جدولك اليومي بنقرة واحدة.' 
  },
  { 
    step: '03', 
    title: 'احصل على التأكيد والحضور', 
    desc: 'تلقى إشعاراً فورياً وحضر للمركز بدون الحاجة لانتظار في الطابور.' 
  },
];

export default function FeaturesSection() {
  return (
    <section className="relative py-12 px-4 overflow-hidden text-slate-800 dark:text-slate-100 transition-colors duration-300">
      <div className="max-w-5xl mx-auto relative z-10">
        
        {/* العنوان الرئيسي للقسم */}
        <motion.div 
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6, ease: 'easeOut' }}
          className="text-center max-w-2xl mx-auto mb-16 space-y-4"
        >
          <div className="inline-flex items-center gap-2 bg-white/80 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 text-xs sm:text-sm font-bold px-5 py-2 rounded-full border border-amber-500/30 backdrop-blur-md shadow-sm">
            <span className="w-2 h-2 rounded-full bg-amber-500 dark:bg-amber-400 animate-pulse" />
            كيف نعمل؟
          </div>

          <h2 className="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-[1.25]">
            3 خطوات بسيطة لحجز وتنسيق موعدك
          </h2>
        </motion.div>

        {/* شبكة الخطوات */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {steps.map((item, idx) => (
            <motion.div 
              key={idx}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.5, delay: idx * 0.15 }}
              whileHover={{ y: -6 }}
              className="relative p-8 rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-800 text-center shadow-md hover:border-amber-500/50 hover:shadow-xl transition-all duration-300 group backdrop-blur-md"
            >
              <span className="text-5xl font-black text-amber-600/20 dark:text-amber-400/20 absolute top-4 left-6 font-mono select-none group-hover:scale-110 transition-transform duration-300">
                {item.step}
              </span>

              <h3 className="text-xl font-bold text-slate-900 dark:text-white mb-3 relative z-10 mt-2">
                {item.title}
              </h3>

              <p className="text-sm text-slate-700 dark:text-slate-300 font-medium leading-relaxed">
                {item.desc}
              </p>
            </motion.div>
          ))}
        </div>

      </div>
    </section>
  );
}
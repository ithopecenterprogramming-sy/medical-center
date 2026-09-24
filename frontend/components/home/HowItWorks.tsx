'use client';

import { motion } from 'framer-motion';

const steps = [
  { step: '01', title: 'اختر العيادة أو الطبيب', desc: 'استعرض الأطباء والتخصصات المتاحة بسهولة مع جدول الأوقات.' },
  { step: '02', title: 'حدد الموعد المناسب', desc: 'اختر الوقت والتاريخ الذي يناسب جدولك اليومي بنقرة واحدة.' },
  { step: '03', title: 'احصل على التأكيد والحضور', desc: 'تلقى إشعاراً فورياً وحضر للمركز بدون الحاجة لانتظار في الطابور.' },
];

export default function FeaturesSection() {
  return (
    <section className="py-20 relative bg-amber-50/40 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-300">
      
      <div className="container mx-auto px-4 sm:px-6 relative z-10">
        
        <motion.div 
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          className="text-center max-w-2xl mx-auto mb-16 space-y-3"
        >
          <span className="inline-block px-4 py-1.5 rounded-full bg-amber-100/80 dark:bg-slate-900 border border-amber-300/50 dark:border-amber-500/30 text-amber-800 dark:text-amber-400 text-xs font-bold">
            كيف نعمل؟
          </span>
          <h2 className="text-3xl sm:text-4xl font-black text-amber-950 dark:text-slate-100 tracking-tight">
            3 خطوات بسيطة لحجز وتنسيق موعدك
          </h2>
        </motion.div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
          {steps.map((item, idx) => (
            <motion.div 
              key={idx}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.5, delay: idx * 0.15 }}
              whileHover={{ y: -4 }}
              className="relative p-8 rounded-3xl bg-amber-100/30 dark:bg-slate-900/90 border border-amber-200/60 dark:border-slate-800 text-center shadow-sm hover:border-amber-400 transition-all duration-300"
            >
              <span className="text-5xl font-black text-amber-600/20 dark:text-amber-500/20 absolute top-4 left-6 font-mono select-none">
                {item.step}
              </span>
              <h3 className="text-xl font-bold text-amber-950 dark:text-slate-100 mb-3 relative z-10 mt-2">
                {item.title}
              </h3>
              <p className="text-xs sm:text-sm text-amber-900/70 dark:text-slate-400 font-medium leading-relaxed">
                {item.desc}
              </p>
            </motion.div>
          ))}
        </div>

      </div>
    </section>
  );
}
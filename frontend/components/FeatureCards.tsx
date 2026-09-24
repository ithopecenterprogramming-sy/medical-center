'use client';

import { motion, Variants } from 'framer-motion';

const cardVariants: Variants = {
  hidden: { opacity: 0, y: 30 },
  visible: (i: number) => ({
    opacity: 1,
    y: 0,
    transition: {
      delay: i * 0.15,
      duration: 0.5,
      ease: 'easeOut',
    },
  }),
};

interface CardItem {
  num: string;
  title: string;
  desc: string;
  icon: string;
}

const cards: CardItem[] = [
  {
    num: '01',
    title: 'إدارة المواعيد',
    desc: 'تنظيم حجز المواعيد وتوزيعها على الأطباء بمرونة عالية لمنع التداخل والانتظار الطويل.',
    icon: '🗓️',
  },
  {
    num: '02',
    title: 'الملفات الطبية',
    desc: 'حفظ واسترجاع سجلات المرضى والتشخيصات الطبية بمرونة فائقة وأعلى درجات الأمان.',
    icon: '📁',
  },
  {
    num: '03',
    title: 'صلاحيات الأدوار',
    desc: 'واجهات ولوحات تحكم مخصصة لكل من المدير، الطبيب، وموظف الاستقبال لانسيابية العمل.',
    icon: '🔐',
  },
];

export default function FeatureCards() {
  return (
    <div className="grid md:grid-cols-3 gap-8">
      {cards.map((card, index) => (
        <motion.div
          key={card.num}
          custom={index}
          initial="hidden"
          animate="visible"
          variants={cardVariants}
          className="group relative bg-white dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-800 hover:border-amber-500/50 p-8 rounded-3xl transition-all duration-300 hover:-translate-y-2 shadow-lg shadow-slate-200/40 dark:shadow-none hover:shadow-xl hover:shadow-amber-500/10 backdrop-blur-md overflow-hidden flex flex-col justify-between"
        >
          {/* شريط أعلى الكارت يظهر عند التحويم */}
          <div className="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-amber-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

          <div>
            {/* الرأس: الإيقونة والرقم */}
            <div className="flex items-center justify-between mb-6">
              <div className="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 text-xl flex items-center justify-center shadow-inner">
                {card.icon}
              </div>
              <span className="text-3xl font-black text-slate-300 dark:text-slate-700 group-hover:text-amber-500/40 transition-colors">
                {card.num}
              </span>
            </div>

            {/* العنوان والوصف */}
            <h3 className="text-2xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
              {card.title}
            </h3>
            <p className="text-slate-600 dark:text-slate-400 text-sm leading-relaxed font-medium transition-colors duration-300">
              {card.desc}
            </p>
          </div>
        </motion.div>
      ))}
    </div>
  );
}
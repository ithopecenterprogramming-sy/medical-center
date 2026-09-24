'use client';

import { useEffect, useState } from 'react';

interface CounterProps {
  from?: number;
  to: number;
  duration?: number; // بالثواني
}

export default function Counter({ from = 0, to = 100, duration = 2 }: CounterProps) {
  const [count, setCount] = useState(from);

  useEffect(() => {
    let start = from;
    const increment = (to - from) / (duration * 60); // 60 إطار في الثانية
    const timer = setInterval(() => {
      start += increment;
      if (start >= to) {
        setCount(to);
        clearInterval(timer);
      } else {
        setCount(Math.floor(start));
      }
    }, 1000 / 60);

    return () => clearInterval(timer);
  }, [from, to, duration]);

  return <span>{count}%</span>;
}
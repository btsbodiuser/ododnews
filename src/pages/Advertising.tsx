import { motion } from 'framer-motion';
import { Megaphone, Target, BarChart3, Check } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Link } from 'react-router-dom';

export default function Advertising() {
  const packages = [
    {
      name: 'Basic',
      price: '₮500,000',
      per: '7 хоног',
      features: ['Баннер байршил', '50,000+ харагдац', 'Статистик тайлан'],
    },
    {
      name: 'Pro',
      price: '₮1,500,000',
      per: '30 хоног',
      features: ['Баннер + Видео', '250,000+ харагдац', 'Нийтлэлийн хамтын ажиллагаа', 'Social media push'],
      popular: true,
    },
    {
      name: 'Custom',
      price: 'Тусгай',
      per: 'санал',
      features: ['Brand campaign', 'Influencer хамтрал', 'Арга хэмжээний хамтрал'],
    },
  ];

  return (
    <div className="max-w-6xl mx-auto px-4 py-12 lg:py-16">
      <motion.div
        initial={{ opacity: 0, y: 16 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.4 }}
      >
        <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-gradient text-white text-[11px] font-black uppercase tracking-[0.18em]">
          <Megaphone className="w-3.5 h-3.5" /> Зар сурталчилгаа
        </div>
        <h1 className="mt-4 text-4xl lg:text-5xl font-black leading-tight">
          Брэндээ <span className="bg-brand-gradient bg-clip-text text-transparent">оддын түвшинд</span>
        </h1>
        <p className="mt-4 text-lg text-muted-foreground max-w-2xl">
          ODOD News-тэй хамтран сарын 1 саяас дээш уншигчдын өмнө брэндээ цацна.
          Таргет, креатив, тайлан бүгд нэг дороос.
        </p>
      </motion.div>

      <div className="grid sm:grid-cols-3 gap-4 mt-12">
        {[
          { icon: Target, k: '1.2M+', v: 'Сарын уншигч' },
          { icon: BarChart3, k: '4.8M+', v: 'Сарын харагдац' },
          { icon: Megaphone, k: '180K+', v: 'Social дагагч' },
        ].map(({ icon: Icon, k, v }) => (
          <div key={v} className="p-6 rounded-2xl border border-border bg-card">
            <Icon className="w-6 h-6 text-brand-pink" />
            <p className="mt-3 text-3xl font-black">{k}</p>
            <p className="text-sm text-muted-foreground">{v}</p>
          </div>
        ))}
      </div>

      <h2 className="mt-16 text-2xl font-black">Багцууд</h2>
      <div className="grid md:grid-cols-3 gap-4 mt-6">
        {packages.map((p) => (
          <div
            key={p.name}
            className={`relative p-6 rounded-2xl border ${p.popular ? 'border-brand-pink bg-brand-pink/5' : 'border-border bg-card'}`}
          >
            {p.popular && (
              <span className="absolute -top-2.5 left-6 bg-brand-gradient text-white text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full">
                Эрэлттэй
              </span>
            )}
            <p className="text-xs font-black uppercase tracking-widest text-muted-foreground">{p.name}</p>
            <div className="flex items-baseline gap-2 mt-3">
              <span className="text-3xl font-black">{p.price}</span>
              <span className="text-sm text-muted-foreground">/ {p.per}</span>
            </div>
            <ul className="mt-5 space-y-2 text-sm">
              {p.features.map((f) => (
                <li key={f} className="flex items-start gap-2">
                  <Check className="w-4 h-4 text-brand-pink shrink-0 mt-0.5" />
                  {f}
                </li>
              ))}
            </ul>
          </div>
        ))}
      </div>

      <div className="mt-12 p-8 rounded-2xl bg-brand-gradient text-white flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
          <p className="text-[11px] font-black uppercase tracking-[0.2em] opacity-80">Дараагийн алхам</p>
          <h3 className="text-2xl font-black mt-1">Санал асууя</h3>
        </div>
        <Link to="/contact">
          <Button size="lg" className="rounded-full bg-white text-brand-pink hover:bg-white/90 font-bold">
            Холбоо барих →
          </Button>
        </Link>
      </div>
    </div>
  );
}

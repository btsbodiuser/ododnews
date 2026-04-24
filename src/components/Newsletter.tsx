import { useState } from 'react';
import { Mail, Sparkles } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

export default function Newsletter() {
  const [email, setEmail] = useState('');
  const [status, setStatus] = useState<'idle' | 'ok'>('idle');

  const onSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!email) return;
    setStatus('ok');
    setEmail('');
    setTimeout(() => setStatus('idle'), 3000);
  };

  return (
    <section className="mt-16">
      <div className="relative overflow-hidden rounded-3xl bg-brand-gradient text-white p-8 md:p-12">
        {/* Decorative sparkles */}
        <Sparkles className="absolute top-6 right-8 w-20 h-20 text-white/10" />
        <Sparkles className="absolute bottom-6 left-10 w-12 h-12 text-white/10" />

        <div className="relative grid md:grid-cols-2 gap-6 items-center">
          <div>
            <div className="inline-flex items-center gap-2 bg-black/20 backdrop-blur-sm rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider mb-3">
              <Mail className="w-3 h-3" />
              Мэйлд шууд
            </div>
            <h2 className="headline-display text-3xl md:text-4xl">
              Оддын хамгийн шинэ цуурхал — таны имэйлд.
            </h2>
            <p className="mt-3 text-white/85 max-w-md">
              Өдөр бүр нэг удаа, хамгийн халуун мэдээ, фото, цуурхлыг цэгцтэй
              багцалж хүргэнэ. Ямар ч спам байхгүй.
            </p>
          </div>

          <form onSubmit={onSubmit} className="flex flex-col gap-3">
            <div className="flex flex-col sm:flex-row gap-2">
              <Input
                type="email"
                required
                placeholder="tani-email@example.com"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                className="flex-1 bg-white text-black placeholder:text-black/50 rounded-full h-12 px-5 border-0"
              />
              <Button
                type="submit"
                size="lg"
                className="rounded-full bg-black text-white hover:bg-white hover:text-black transition-colors border-0 px-6"
              >
                Бүртгүүлэх
              </Button>
            </div>
            {status === 'ok' && (
              <p className="text-sm text-brand-gold font-semibold">
                ✨ Бүртгэгдлээ. Удахгүй уулзая!
              </p>
            )}
            <p className="text-[11px] text-white/70">
              Бүртгүүлснээр та үйлчилгээний нөхцөлийг зөвшөөрнө.
            </p>
          </form>
        </div>
      </div>
    </section>
  );
}

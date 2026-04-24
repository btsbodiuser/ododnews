import { Link, useNavigate } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import { Menu, Search, Sun, Moon, X, Sparkles } from 'lucide-react';
import { useEffect, useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { getMenuCategories } from '@/services/api';
import { useThemeStore, useMobileMenuStore } from '@/store';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import Logo from '@/components/Logo';

function formatMongolianDate(d: Date) {
  const months = [
    '1 сар', '2 сар', '3 сар', '4 сар', '5 сар', '6 сар',
    '7 сар', '8 сар', '9 сар', '10 сар', '11 сар', '12 сар',
  ];
  const weekdays = ['Ням', 'Даваа', 'Мягмар', 'Лхагва', 'Пүрэв', 'Баасан', 'Бямба'];
  return `${weekdays[d.getDay()]}, ${d.getFullYear()} оны ${months[d.getMonth()]}ын ${d.getDate()}`;
}

export default function Header() {
  const { isDark, toggle } = useThemeStore();
  const { isOpen, toggle: toggleMenu, close } = useMobileMenuStore();
  const [searchOpen, setSearchOpen] = useState(false);
  const [searchQuery, setSearchQuery] = useState('');
  const [scrolled, setScrolled] = useState(false);
  const navigate = useNavigate();

  const { data: categories = [] } = useQuery({
    queryKey: ['menu-categories'],
    queryFn: getMenuCategories,
    staleTime: 5 * 60 * 1000,
  });

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 80);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
    return () => window.removeEventListener('scroll', onScroll);
  }, []);

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    if (searchQuery.trim()) {
      navigate(`/search?q=${encodeURIComponent(searchQuery.trim())}`);
      setSearchQuery('');
      setSearchOpen(false);
    }
  };

  const today = formatMongolianDate(new Date());

  return (
    <header className="sticky top-0 z-50 bg-background/85 backdrop-blur-xl border-b border-border">
      {/* Top strip */}
      <div className="hidden md:block bg-brand-gradient text-white">
        <div className="max-w-7xl mx-auto px-4 h-8 flex items-center justify-between text-xs font-medium">
          <div className="flex items-center gap-3">
            <Sparkles className="w-3.5 h-3.5" />
            <span className="tracking-wide">{today}</span>
          </div>
          <div className="flex items-center gap-3">
            <a href="#" aria-label="Instagram" className="hover:text-brand-gold transition-colors text-[10px] font-black tracking-widest">
              IG
            </a>
            <a href="#" aria-label="Facebook" className="hover:text-brand-gold transition-colors text-[10px] font-black tracking-widest">
              FB
            </a>
            <a href="#" aria-label="YouTube" className="hover:text-brand-gold transition-colors text-[10px] font-black tracking-widest">
              YT
            </a>
            <span className="hidden lg:inline opacity-80 ml-2">ОДНУУДЫН АМЬДРАЛ · ЦУУРХАЛ · ЗАГВАР</span>
            <Link to="/login" className="hover:text-brand-gold transition-colors ml-1">
              Нэвтрэх →
            </Link>
          </div>
        </div>
      </div>

      {/* Masthead */}
      <div className="max-w-7xl mx-auto px-4">
        <motion.div
          animate={{ height: scrolled ? 56 : 88 }}
          transition={{ duration: 0.25, ease: 'easeOut' }}
          className="flex items-center justify-between"
        >
          {/* Mobile menu */}
          <Sheet open={isOpen} onOpenChange={toggleMenu}>
            <SheetTrigger
              aria-label="Цэс нээх"
              className="lg:hidden inline-flex items-center justify-center rounded-full h-10 w-10 hover:bg-accent transition-colors cursor-pointer"
            >
              <Menu className="h-5 w-5" />
            </SheetTrigger>
            <SheetContent side="left" className="w-80 p-0">
              <div className="bg-brand-navy text-white p-6">
                <Link to="/" onClick={close} className="inline-block">
                  <Logo variant="white" size="md" />
                </Link>
                <p className="text-xs mt-3 opacity-90 tracking-wide">Одод. Цуурхал. Загвар.</p>
              </div>
              <nav className="p-4 space-y-1">
                {categories.map((cat) => (
                  <Link
                    key={cat.id}
                    to={`/category/${cat.slug}`}
                    onClick={close}
                    className="flex items-center px-3 py-2.5 rounded-lg hover:bg-accent transition-colors font-semibold"
                  >
                    <span
                      className="inline-block w-2.5 h-2.5 rounded-full mr-3"
                      style={{ backgroundColor: cat.color || 'var(--brand-pink)' }}
                    />
                    {cat.name}
                  </Link>
                ))}
              </nav>
            </SheetContent>
          </Sheet>

          {/* Logo */}
          <Link to="/" className="flex items-center group transition-all">
            <Logo size={scrolled ? 'sm' : 'md'} showTagline />
          </Link>

          {/* Right actions */}
          <div className="flex items-center gap-1">
            <Button
              variant="ghost"
              size="icon"
              aria-label="Хайх"
              onClick={() => setSearchOpen(!searchOpen)}
              className="rounded-full"
            >
              {searchOpen ? <X className="h-5 w-5" /> : <Search className="h-5 w-5" />}
            </Button>
            <Button
              variant="ghost"
              size="icon"
              aria-label={isDark ? 'Гэрэл горим' : 'Харанхуй горим'}
              onClick={toggle}
              className="rounded-full"
            >
              {isDark ? <Sun className="h-5 w-5" /> : <Moon className="h-5 w-5" />}
            </Button>
            <Link to="/login" className="hidden sm:inline-flex">
              <Button
                size="sm"
                className="rounded-full bg-brand-gradient text-white hover:opacity-90 border-0 shadow-md"
              >
                Нэвтрэх
              </Button>
            </Link>
          </div>
        </motion.div>
      </div>

      {/* Desktop Navigation */}
      <nav className="hidden lg:block border-t border-border/70">
        <div className="max-w-7xl mx-auto px-4">
          <div className="flex items-center gap-1 h-11 overflow-x-auto scrollbar-hide">
            {categories.map((cat) => {
              const color = cat.color || 'var(--brand-pink)';
              return (
                <Link
                  key={cat.id}
                  to={`/category/${cat.slug}`}
                  className="relative px-3 py-1.5 text-sm font-semibold text-foreground/75 hover:text-foreground transition-colors whitespace-nowrap group"
                >
                  {cat.name}
                  <span
                    className="absolute left-3 right-3 -bottom-px h-0.5 origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"
                    style={{ backgroundColor: color }}
                  />
                </Link>
              );
            })}
          </div>
        </div>
      </nav>

      {/* Search bar */}
      <AnimatePresence>
        {searchOpen && (
          <motion.div
            initial={{ height: 0, opacity: 0 }}
            animate={{ height: 'auto', opacity: 1 }}
            exit={{ height: 0, opacity: 0 }}
            className="overflow-hidden border-t border-border"
          >
            <div className="max-w-7xl mx-auto px-4 py-3">
              <form onSubmit={handleSearch} className="flex gap-2">
                <Input
                  type="text"
                  placeholder="Алдартныг хайх..."
                  value={searchQuery}
                  onChange={(e) => setSearchQuery(e.target.value)}
                  className="flex-1 rounded-full"
                  autoFocus
                />
                <Button
                  type="submit"
                  className="rounded-full bg-brand-gradient text-white border-0"
                >
                  Хайх
                </Button>
              </form>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </header>
  );
}

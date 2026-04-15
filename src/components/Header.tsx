import { Link } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import { Menu, Search, Sun, Moon, X } from 'lucide-react';
import { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { getMenuCategories } from '@/services/api';
import { useThemeStore, useMobileMenuStore } from '@/store';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import { useNavigate } from 'react-router-dom';

export default function Header() {
  const { isDark, toggle } = useThemeStore();
  const { isOpen, toggle: toggleMenu, close } = useMobileMenuStore();
  const [searchOpen, setSearchOpen] = useState(false);
  const [searchQuery, setSearchQuery] = useState('');
  const navigate = useNavigate();

  const { data: categories = [] } = useQuery({
    queryKey: ['menu-categories'],
    queryFn: getMenuCategories,
    staleTime: 5 * 60 * 1000,
  });

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    if (searchQuery.trim()) {
      navigate(`/search?q=${encodeURIComponent(searchQuery.trim())}`);
      setSearchQuery('');
      setSearchOpen(false);
    }
  };

  return (
    <header className="sticky top-0 z-50 bg-white/80 dark:bg-gray-950/80 backdrop-blur-xl border-b border-gray-200 dark:border-gray-800">
      {/* Top bar */}
      <div className="max-w-7xl mx-auto px-4">
        <div className="flex items-center justify-between h-16">
          {/* Mobile menu */}
          <Sheet open={isOpen} onOpenChange={toggleMenu}>
            <SheetTrigger className="lg:hidden inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all h-9 w-9 hover:bg-accent hover:text-accent-foreground cursor-pointer">
              <Menu className="h-5 w-5" />
            </SheetTrigger>
            <SheetContent side="left" className="w-80 p-0">
              <div className="p-6">
                <Link to="/" onClick={close} className="text-2xl font-bold text-red-600">
                  ODOD
                </Link>
                <nav className="mt-8 space-y-1">
                  {categories.map((cat) => (
                    <Link
                      key={cat.id}
                      to={`/category/${cat.slug}`}
                      onClick={close}
                      className="block px-3 py-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors font-medium"
                    >
                      <span className="inline-block w-2 h-2 rounded-full mr-3" style={{ backgroundColor: cat.color }} />
                      {cat.name}
                    </Link>
                  ))}
                </nav>
              </div>
            </SheetContent>
          </Sheet>

          {/* Logo */}
          <Link to="/" className="flex items-center gap-2">
            <span className="text-2xl md:text-3xl font-black tracking-tight">
              <span className="text-red-600">ODOD</span>
              <span className="text-gray-400 dark:text-gray-600 text-sm font-medium ml-1">МЭДЭЭ</span>
            </span>
          </Link>

          {/* Right actions */}
          <div className="flex items-center gap-2">
            {/* Search toggle */}
            <Button variant="ghost" size="icon" onClick={() => setSearchOpen(!searchOpen)}>
              {searchOpen ? <X className="h-5 w-5" /> : <Search className="h-5 w-5" />}
            </Button>

            {/* Theme toggle */}
            <Button variant="ghost" size="icon" onClick={toggle}>
              {isDark ? <Sun className="h-5 w-5" /> : <Moon className="h-5 w-5" />}
            </Button>

            <Link to="/login">
              <Button variant="outline" size="sm" className="hidden sm:inline-flex">
                Нэвтрэх
              </Button>
            </Link>
          </div>
        </div>
      </div>

      {/* Desktop Navigation */}
      <nav className="hidden lg:block border-t border-gray-100 dark:border-gray-800/50">
        <div className="max-w-7xl mx-auto px-4">
          <div className="flex items-center gap-1 h-11 overflow-x-auto scrollbar-hide">
            {categories.map((cat) => (
              <Link
                key={cat.id}
                to={`/category/${cat.slug}`}
                className="px-3 py-1.5 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors whitespace-nowrap"
              >
                {cat.name}
              </Link>
            ))}
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
            className="overflow-hidden border-t border-gray-100 dark:border-gray-800"
          >
            <div className="max-w-7xl mx-auto px-4 py-3">
              <form onSubmit={handleSearch} className="flex gap-2">
                <Input
                  type="text"
                  placeholder="Мэдээ хайх..."
                  value={searchQuery}
                  onChange={(e) => setSearchQuery(e.target.value)}
                  className="flex-1"
                  autoFocus
                />
                <Button type="submit">Хайх</Button>
              </form>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </header>
  );
}

import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { Button } from '@/components/ui/button';

export default function NotFound() {
  return (
    <div className="min-h-[60vh] flex items-center justify-center px-4">
      <motion.div
        initial={{ opacity: 0, scale: 0.95 }}
        animate={{ opacity: 1, scale: 1 }}
        className="text-center"
      >
        <h1 className="text-8xl font-black text-gray-200 dark:text-gray-800">404</h1>
        <p className="text-xl font-semibold text-gray-900 dark:text-white mt-4">
          Хуудас олдсонгүй
        </p>
        <p className="text-gray-500 mt-2">
          Таны хайж буй хуудас устсан эсвэл байхгүй байна.
        </p>
        <Link to="/" className="mt-6 inline-block">
          <Button>Нүүр хуудас руу буцах</Button>
        </Link>
      </motion.div>
    </div>
  );
}

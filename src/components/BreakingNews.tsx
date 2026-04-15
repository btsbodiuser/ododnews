import { useQuery } from '@tanstack/react-query';
import { Zap } from 'lucide-react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { getBreakingArticles } from '@/services/api';

export default function BreakingNews() {
  const { data: articles = [] } = useQuery({
    queryKey: ['breaking-articles'],
    queryFn: getBreakingArticles,
    staleTime: 60 * 1000,
  });

  if (articles.length === 0) return null;

  return (
    <div className="bg-red-600 text-white">
      <div className="max-w-7xl mx-auto px-4">
        <div className="flex items-center gap-3 py-2.5 overflow-hidden">
          <div className="flex items-center gap-1.5 shrink-0">
            <Zap className="w-4 h-4 fill-current" />
            <span className="text-sm font-bold uppercase tracking-wide">Яаралтай</span>
          </div>
          <div className="overflow-hidden">
            <motion.div
              className="flex gap-8 whitespace-nowrap"
              animate={{ x: ['0%', '-50%'] }}
              transition={{ duration: 20, repeat: Infinity, ease: 'linear' }}
            >
              {[...articles, ...articles].map((article, i) => (
                <Link
                  key={`${article.id}-${i}`}
                  to={`/article/${article.slug}`}
                  className="text-sm hover:underline"
                >
                  {article.title}
                </Link>
              ))}
            </motion.div>
          </div>
        </div>
      </div>
    </div>
  );
}

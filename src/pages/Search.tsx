import { useState } from 'react';
import { useSearchParams } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import { Search as SearchIcon } from 'lucide-react';
import { searchArticles } from '@/services/api';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import ArticleCard from '@/components/ArticleCard';
import Pagination from '@/components/Pagination';
import { ArticleCardSkeleton } from '@/components/Skeletons';

export default function SearchPage() {
  const [searchParams, setSearchParams] = useSearchParams();
  const q = searchParams.get('q') || '';
  const page = Number(searchParams.get('page')) || 1;
  const [query, setQuery] = useState(q);

  const { data, isLoading } = useQuery({
    queryKey: ['search', q, page],
    queryFn: () => searchArticles(q, page),
    enabled: q.length >= 2,
  });

  const articles = data?.data ?? [];
  const meta = data?.meta;

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    if (query.trim().length >= 2) {
      setSearchParams({ q: query.trim() });
    }
  };

  return (
    <div className="max-w-7xl mx-auto px-4 py-8">
      <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-6">Хайлт</h1>

      <form onSubmit={handleSearch} className="flex gap-2 mb-8 max-w-xl">
        <Input
          type="text"
          placeholder="Мэдээ хайх..."
          value={query}
          onChange={(e) => setQuery(e.target.value)}
          className="flex-1"
        />
        <Button type="submit">
          <SearchIcon className="w-4 h-4 mr-2" />
          Хайх
        </Button>
      </form>

      {q && (
        <p className="text-gray-500 mb-6">
          "<span className="font-medium text-gray-900 dark:text-white">{q}</span>" хайлтын үр дүн
          {meta && ` (${meta.total} мэдээ олдлоо)`}
        </p>
      )}

      {isLoading ? (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {Array.from({ length: 6 }).map((_, i) => (
            <ArticleCardSkeleton key={i} />
          ))}
        </div>
      ) : articles.length === 0 && q ? (
        <div className="text-center py-16 text-gray-500">
          <SearchIcon className="w-12 h-12 mx-auto mb-4 text-gray-300" />
          <p className="text-lg">Хайлтын үр дүн олдсонгүй</p>
          <p className="text-sm mt-1">Өөр түлхүүр үг ашиглан дахин хайна уу</p>
        </div>
      ) : (
        <>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {articles.map((article) => (
              <ArticleCard key={article.id} article={article} />
            ))}
          </div>
          {meta && (
            <Pagination
              currentPage={meta.current_page}
              lastPage={meta.last_page}
              onPageChange={(p) => setSearchParams({ q, page: String(p) })}
            />
          )}
        </>
      )}
    </div>
  );
}

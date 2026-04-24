import { useState } from 'react';

type LogoVariant = 'color' | 'white';

interface Props {
  variant?: LogoVariant;
  className?: string;
  showTagline?: boolean;
  size?: 'sm' | 'md' | 'lg';
}

const FILE: Record<LogoVariant, string> = {
  color: '/ododnews/logo.png',
  white: '/ododnews/logo-white.png',
};

const HEIGHT: Record<NonNullable<Props['size']>, string> = {
  sm: 'h-7',
  md: 'h-10',
  lg: 'h-14',
};

// Image-first logo with text-wordmark fallback so the header still renders
// cleanly before logo.png is saved into /public.
export default function Logo({
  variant = 'color',
  className = '',
  showTagline = false,
  size = 'md',
}: Props) {
  const [failed, setFailed] = useState(false);

  if (failed) {
    return (
      <span className={`inline-flex items-baseline gap-1 ${className}`}>
        <span className="font-black tracking-tighter text-brand-gradient headline-display text-3xl">
          ODOD
        </span>
        {showTagline && (
          <span className="text-[10px] font-bold uppercase tracking-[0.2em] text-muted-foreground">
            Stars · News
          </span>
        )}
      </span>
    );
  }

  return (
    <span className={`inline-flex items-center gap-2 ${className}`}>
      <img
        src={FILE[variant]}
        alt="ODOD NEWS"
        onError={() => setFailed(true)}
        className={`${HEIGHT[size]} w-auto object-contain`}
      />
      {showTagline && (
        <span className="hidden sm:inline text-[10px] font-bold uppercase tracking-[0.2em] text-muted-foreground">
          Stars · News
        </span>
      )}
    </span>
  );
}

import ApplicationLogo from '@/Components/ApplicationLogo';
import {Link} from '@inertiajs/react';

export default function GuestLayout({children}) {
    return (
        <div className="flex min-h-screen flex-col bg-gray-100 pt-6 sm:pt-4">
            <div className="container">
                <div className="flex items-center justify-between">
                    <div>
                        <Link href="/">
                            <h2 className="fill-current text-3xl text-gra]">
                                Vaccine System
                            </h2>
                        </Link>
                    </div>
                    <div className='flex gap-4'>
                        <Link href={route('home')}>
                            Home
                        </Link>
                        <Link href={route('enroll.index')}>
                            Enroll
                        </Link>
                    </div>
                </div>
            </div>
            <div className="container">
                {children}
            </div>
        </div>
    );
}

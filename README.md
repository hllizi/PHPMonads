# PHPMonads

This repository defines a trait MonadTrait. The trait demands two abstract methods to be implemented by every using class, bind and return. These correspond to >>= and "return" in Haskell's Monad interface. The trait further implements join() and map() on the basis of these two methods.

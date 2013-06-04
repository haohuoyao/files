package main

import (
  "syscall"
	"flag"
)

func main() {
	a:=flag.Int("a",500,"")
	b:=flag.Int("b",3000,"")
	flag.Parse()
	k := syscall.MustLoadDLL("kernel32.dll")
	k.MustFindProc("Beep").Call(uintptr(*a),uintptr(*b))
}

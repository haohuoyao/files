package main

import (
  "syscall"
	"flag"
)

func main() {
	a:=flag.Int("a",1000,"")
	b:=flag.Int("b",2000,"") // two seconds
	flag.Parse()
	k := syscall.MustLoadDLL("kernel32.dll")
	k.MustFindProc("Beep").Call(uintptr(*a),uintptr(*b))
}
